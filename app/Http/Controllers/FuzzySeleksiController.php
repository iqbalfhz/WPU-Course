<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandidat;

class FuzzySeleksiController extends Controller
{
    /**
     * Menampilkan hasil seleksi fuzzy (Sugeno 0) untuk seluruh kandidat.
     * - Ambil data kandidat
     * - Fuzzifikasi (triangular membership) untuk tiap variabel
     * - Evaluasi rule Sugeno (konsekuen konstanta)
     * - Defuzzifikasi (weighted average Σ(α·y)/Σα)
     * - Urutkan berdasarkan skor fuzzy (desc)
     */
    public function index()
    {
        // 1) Ambil semua kandidat dari DB
        $kandidats = Kandidat::query()->get();

        // 2) Helper fungsi membership Triangular (a ≤ b ≤ c)
        //    Menghasilkan derajat keanggotaan μ(x) ∈ [0,1]
        //    - 0 di luar [a,c]
        //    - puncak 1 di x=b
        //    - linear naik/turun pada sisi kiri/kanan
        $tri = function (float $x, float $a, float $b, float $c): float {
            if ($x <= $a || $x >= $c) return 0.0;           // di luar segitiga → μ=0
            if ($x == $b) return 1.0;                       // di puncak → μ=1
            return ($x < $b)
                ? ($x - $a) / max(1e-9, ($b - $a))         // sisi kiri (naik)
                : ($c - $x) / max(1e-9, ($c - $b));        // sisi kanan (turun)
        };

        // 3) Definisi 5 label umum (overlap) untuk skala 0–100
        //    Nilai cut a,b,c bisa dikalibrasi sesuai kebutuhan bisnis
        $mfAll = function (float $x) use ($tri): array {
            return [
                'sangat_kurang' => $tri($x,   0,   0,  25),  // tri(0,0,25) → tajam di 0, memudar hingga 25
                'kurang'        => $tri($x,  10,  25,  50),  // tri(10,25,50)
                'standar'       => $tri($x,  40,  60,  75),  // tri(40,60,75)
                'baik'          => $tri($x,  65,  80,  90),  // tri(65,80,90)
                'unggul'        => $tri($x,  85, 100, 100),  // tri(85,100,100) → puncak di 100
            ];
        };

        // 4) Proses setiap kandidat → hitung skor fuzzy
        $results = $kandidats->map(function ($k) use ($mfAll) {
            // 4a) Normalisasi & guard: bila null/non-numeric → 0.0
            $akademik    = is_numeric($k->nilai_akademik)         ? (float)$k->nilai_akademik         : 0.0;
            $teknis      = is_numeric($k->tes_kompetensi_teknis)  ? (float)$k->tes_kompetensi_teknis  : 0.0;
            $psikotes    = is_numeric($k->tes_psikotes)           ? (float)$k->tes_psikotes           : 0.0;
            $kepribadian = is_numeric($k->tes_kepribadian)        ? (float)$k->tes_kepribadian        : 0.0;
            $soft        = is_numeric($k->soft_skill)             ? (float)$k->soft_skill             : 0.0;

            // 4b) Fuzzifikasi: hitung derajat μ label untuk tiap variabel
            $μA = $mfAll($akademik);     // μ untuk Akademik
            $μT = $mfAll($teknis);       // μ untuk Teknis
            $μP = $mfAll($psikotes);     // μ untuk Psikotes
            $μK = $mfAll($kepribadian);  // μ untuk Kepribadian
            $μS = $mfAll($soft);         // μ untuk Soft Skill

            // Kumpulan rule aktif dalam bentuk pasangan (α, y)
            // α = fire strength (min/max atas μ input), y = konsekuen konstanta Sugeno 0
            $rules = [];

            // 4c) RULES ————————————————

            // R1: Semua variabel "unggul" → output 100
            //     α = min(μ_unggul dari semua variabel)
            $α = min($μA['unggul'], $μT['unggul'], $μP['unggul'], $μK['unggul'], $μS['unggul']);
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 100];

            // R2: (Akademik OR Teknis) unggul, dan yang lain minimal "baik" → output 95
            //     α = min( max(μA_unggul, μT_unggul), μP_≥baik, μK_≥baik, μS_≥baik )
            $α = min(
                max($μA['unggul'], $μT['unggul']),
                max($μP['baik'], $μP['unggul']),
                max($μK['baik'], $μK['unggul']),
                max($μS['baik'], $μS['unggul'])
            );
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 95];

            // R3: Mayoritas (≥3 variabel) “baik” → output 90
            //     Ambil 3 derajat "baik" terbesar, α = min(ketiganya)
            $baik3 = [ $μA['baik'], $μT['baik'], $μP['baik'], $μK['baik'], $μS['baik'] ];
            rsort($baik3);                              // urut desc
            $α = min($baik3[0], $baik3[1], $baik3[2]); // min dari 3 terbesar
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 90];

            // R4: Semua "standar" → output 75
            //     α = min(μ_standar dari semua variabel)
            $α = min($μA['standar'], $μT['standar'], $μP['standar'], $μK['standar'], $μS['standar']);
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 75];

            // R5: ≥2 variabel berada di (kurang ∨ sangat_kurang) → output 55
            //     Ambil 2 nilai terburuk (max(kurang,sangat_kurang) per variabel), α = min(dua terbesar)
            $low = [
                max($μA['kurang'], $μA['sangat_kurang']),
                max($μT['kurang'], $μT['sangat_kurang']),
                max($μP['kurang'], $μP['sangat_kurang']),
                max($μK['kurang'], $μK['sangat_kurang']),
                max($μS['kurang'], $μS['sangat_kurang']),
            ];
            rsort($low);                  // urut desc → dua yang paling “buruk” (derajat tinggi)
            $α = min($low[0], $low[1]);   // gabungkan dua kondisi low terkuat
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 55];

            // R6: Soft skill “sangat_kurang” (red flag) → output 45
            $α = $μS['sangat_kurang'];
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 45];

            // R7: Kepribadian “kurang/sangat_kurang” (culture risk) → output 60
            $α = max($μK['kurang'], $μK['sangat_kurang']);
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 60];

            // R8: Akademik “unggul” + lainnya minimal “standar” → output 85
            //     α = min( μA_unggul, μT_≥standar, μP_≥standar, μK_≥standar, μS_≥standar )
            $α = min(
                $μA['unggul'],
                max($μT['standar'], $μT['baik'], $μT['unggul']),
                max($μP['standar'], $μP['baik'], $μP['unggul']),
                max($μK['standar'], $μK['baik'], $μK['unggul']),
                max($μS['standar'], $μS['baik'], $μS['unggul'])
            );
            if ($α > 0) $rules[] = ['α' => $α, 'y' => 85];

            // 4d) Fallback:
            //     Jika tidak ada rule aktif sama sekali, gunakan “soft crisp”:
            //     Ubah tiap μ (label) menjadi skor angka (40/55/75/90/100), lalu rata-rata lintas variabel.
            if (empty($rules)) {
                $score = function(array $μ) {
                    $sumμ = array_sum($μ) ?: 1e-9; // hindari div/0
                    return (
                        40 * $μ['sangat_kurang'] +
                        55 * $μ['kurang'] +
                        75 * $μ['standar'] +
                        90 * $μ['baik'] +
                        100 * $μ['unggul']
                    ) / $sumμ;
                };
                $y = ($score($μA) + $score($μT) + $score($μP) + $score($μK) + $score($μS)) / 5.0;
                $rules[] = ['α' => 1.0, 'y' => $y]; // α=1 agar pasti terhitung
            }

            // 4e) Defuzzifikasi Sugeno (weighted average)
            //     z = Σ(α·y) / Σα
            $num = 0.0; $den = 0.0;
            foreach ($rules as $r) {
                $num += $r['α'] * $r['y'];
                $den += $r['α'];
            }
            $z = $den > 0 ? round($num / $den, 2) : 0.0;

            // 4f) Kembalikan ringkasan kandidat + skor
            return [
                'nama'  => $k->nama,
                'email' => $k->email,
                'usia'  => $k->usia,
                'nilai_akademik'         => $akademik,
                'tes_kompetensi_teknis'  => $teknis,
                'tes_psikotes'           => $psikotes,
                'tes_kepribadian'        => $kepribadian,
                'soft_skill'             => $soft,
                'fuzzy_score'            => $z,
            ];
        })
        // 5) Urutkan kandidat dari skor tertinggi → terendah
        ->sortByDesc('fuzzy_score')
        ->values();

        // 6) Kirim ke view hasil
        return view('seleksi.hasil-fuzzy', compact('results'));
    }
}
