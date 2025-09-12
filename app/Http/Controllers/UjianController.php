<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TesOnline;
use App\Models\Kandidat;

class UjianController extends Controller
{
    public function index()
    {
        $title = 'Ujian';
        $tesStats = TesOnline::select('jenis')
            ->selectRaw('COUNT(*) as jumlah_soal')
            ->groupBy('jenis')
            ->get()
            ->keyBy('jenis');

        return view('ujian', compact('title', 'tesStats'));
    }

    public function show(Request $request, string $jenis)
    {
        $jenis = trim($jenis);

        // Batasi jenis yang valid
        $allowed = ['kompetensi_teknis', 'psikotes', 'kepribadian'];
        abort_unless(in_array($jenis, $allowed, true), 404);

        // Ambil soal
        $soals = TesOnline::where('jenis', $jenis)
            ->orderBy('id')
            ->get(['id','jenis','pertanyaan','opsi']);

        $title = 'Tes: ' . ucfirst(str_replace('_', ' ', $jenis));

        return view('ujian-tes', compact('jenis', 'soals', 'title'));
    }

    public function submit(Request $request, string $jenis)
    {
        // Validasi input peserta + jawaban
        $data = $request->validate([
            'nama'    => ['required','string','max:255'],
            'usia'    => ['required','integer','min:17','max:70'],
            'email'   => ['required','email','max:255'],
            'jawaban' => ['array'],
        ]);

        $nama    = $data['nama'];
        $usia    = $data['usia'];
        $email   = $data['email'];
        $jawaban = $data['jawaban'] ?? [];

        // Ambil soal + kunci
        $soals = \App\Models\TesOnline::where('jenis', $jenis)
            ->orderBy('id')
            ->get(['id', 'jawaban_benar']);

        $jumlah_soal = $soals->count();
        $benar = 0;

        if ($jumlah_soal > 0) {
            foreach ($soals as $soal) {
                $jawabPeserta = $jawaban[$soal->id] ?? null;
                if ($jawabPeserta === null || $jawabPeserta === '') continue;

                $kunciArray = (array) ($soal->jawaban_benar ?? []);     // dukung banyak kunci benar
                $kunciArray = array_map(fn($v) => (string) $v, $kunciArray);
                $jawabPeserta = (string) $jawabPeserta;

                if (in_array($jawabPeserta, $kunciArray, true)) {
                    $benar++;
                }
            }
        }

        // Rumus nilai
        $nilai_akhir = $jumlah_soal > 0 ? round(($benar / $jumlah_soal) * 100) : 0;
        $nilai_akhir = max(0, min(100, $nilai_akhir));

        // Upsert kandidat + simpan nilai sesuai jenis
        $kandidat = \App\Models\Kandidat::firstOrNew([
            'email' => $email,
            'nama'  => $nama,
        ]);
        $kandidat->usia = $usia;

        if ($jenis === 'kompetensi_teknis') {
            $kandidat->tes_kompetensi_teknis = $nilai_akhir;
        } elseif ($jenis === 'psikotes') {
            $kandidat->tes_psikotes = $nilai_akhir;
        } elseif ($jenis === 'kepribadian') {
            $kandidat->tes_kepribadian = $nilai_akhir;
        }

        $kandidat->save();

        // Jika AJAX: balas JSON untuk ditampilkan di modal
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'        => 'ok',
                'jenis'         => $jenis,
                'benar'         => $benar,
                'jumlah_soal'   => $jumlah_soal,
                'nilai_akhir'   => $nilai_akhir,
                'message'       => 'Jawaban berhasil disimpan.',
                'links' => [
                    'kompetensi_teknis' => route('ujian.tes', 'kompetensi_teknis'),
                    'psikotes'          => route('ujian.tes', 'psikotes'),
                    'kepribadian'       => route('ujian.tes', 'kepribadian'),
                    'home'              => url('/'),
                ],
            ]);
        }

        // Fallback non-AJAX: redirect biasa
        return redirect()
            ->route('ujian.tes', $jenis)
            ->with('success', "Jawaban disimpan. Skor: $benar / $jumlah_soal → Nilai: $nilai_akhir");
    }
}
