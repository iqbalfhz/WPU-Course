# Dokumentasi: Fuzzy Sugeno Seleksi Karyawan

## 1) Tujuan

Modul ini menghitung **skor kelayakan kandidat** menggunakan **Fuzzy Inference System (FIS) metode Sugeno (orde 0)**.  
Input berasal dari nilai 0–100 beberapa dimensi penilaian:

-   `nilai_akademik`
-   `tes_kompetensi_teknis`
-   `tes_psikotes`
-   `tes_kepribadian`
-   `soft_skill`

Output berupa **skor akhir 0–100** (semakin besar semakin baik), kemudian dipakai untuk **mengurutkan kandidat**.

---

## 2) Dasar Teori Singkat (Sugeno 0)

1. **Fuzzifikasi**: masing-masing input diberi **derajat keanggotaan** pada 5 label:  
   `sangat_kurang`, `kurang`, `standar`, `baik`, `unggul`.  
   Kita memakai **triangular membership function** yang **overlap** (sebuah nilai bisa aktif di >1 label sekaligus).
2. **Inferensi**: setiap **aturan (rule)** menghasilkan **α (fire strength)**, dihitung dengan operator **min / max** atas derajat keanggotaan masukan yang relevan.
3. **Konsekuen**: karena Sugeno orde 0, tiap rule menghasilkan **konstanta** (mis. 100, 95, 90, dst).
4. **Defuzzifikasi**: **weighted average**  
   \[
   z = \frac{\sum (\alpha_i \cdot y_i)}{\sum \alpha_i}
   \]
   di mana \( \alpha_i \) adalah **fire strength** rule ke-i, \( y_i \) adalah **konstanta** dari rule ke-i.

---

## 3) Struktur Data

-   **Model**: `App\Models\Kandidat`  
    Memiliki kolom numeric (0–100): `nilai_akademik`, `tes_kompetensi_teknis`, `tes_psikotes`, `tes_kepribadian`, `soft_skill`.
-   **Controller**: `FuzzySeleksiController@index`  
    Mengambil semua kandidat, menghitung skor fuzzy, lalu mengirim `results` ke view `seleksi.hasil-fuzzy`.

---

## 4) Membership Function (Triangular) yang Dipakai

Rentang untuk skala 0–100 (boleh disesuaikan):

-   `sangat_kurang`: **tri(0, 0, 25)**
-   `kurang`: **tri(10, 25, 50)**
-   `standar`: **tri(40, 60, 75)**
-   `baik`: **tri(65, 80, 90)**
-   `unggul`: **tri(85, 100, 100)**

**Catatan**

-   Overlap antar label **sengaja** dibuat supaya transisi halus.
-   Fungsi `tri(x, a, b, c)` mengembalikan 0 di luar \([a, c]\), puncak 1 di `b`, dan linear naik/turun pada sisi kiri/kanan.

---

## 5) Basis Aturan (Rules) – ringkas

> Semua rule menghasilkan **konstanta output** (konsekuen Sugeno 0).

-   **R1**: _Semua unggul_ → `y = 100`
-   **R2**: _(akademik OR teknis) unggul_ **AND** _lainnya ≥ baik_ → `y = 95`
-   **R3**: _Mayoritas (≥3 variabel) baik_ → `y = 90`
-   **R4**: _Semua standar_ → `y = 75`
-   **R5**: _≥2 variabel tergolong (kurang ∨ sangat_kurang)_ → `y = 55`
-   **R6**: _soft_skill sangat_kurang_ (red-flag) → `y = 45`
-   **R7**: _kepribadian (kurang ∨ sangat_kurang)_ → `y = 60`
-   **R8**: _akademik unggul & lainnya ≥ standar_ → `y = 85`
-   **Fallback**: jika tak ada rule “menyala”, gunakan **rata-rata berbobot** label:  
    \(40\,\mu*{SK} + 55\,\mu*{K} + 75\,\mu*{Std} + 90\,\mu*{B} + 100\,\mu\_{U}\) per variabel lalu dirata-ratakan lintas variabel.

---

## 6) Langkah Perhitungan di Kode

1. Ambil semua kandidat.
2. Untuk tiap kandidat:
    - Normalisasi data non-numeric ke 0 (defensif).
    - Hitung derajat keanggotaan (`μ`) per variabel untuk semua label.
    - **Evaluasi rules** → simpan daftar pasangan `{α, y}`.
    - Jika kosong → jalankan **fallback**.
    - Hitung skor akhir `z = Σ(α·y) / Σα`.
3. Urutkan `results` descending menurut `fuzzy_score`.
4. Kirim `results` ke view untuk ditampilkan.

---

## 7) Kompleksitas

-   Untuk **N** kandidat, **M** variabel (di sini 5), **R** rules (8 + fallback):
    -   Fuzzifikasi: O(N·M·L), L=5 label.
    -   Rule eval: O(N·R).
    -   Total: **O(N)** dengan konstanta kecil; aman untuk ribuan kandidat.

---

## 8) Cara Menyesuaikan

### 8.1 Ubah bentuk membership

Ubah titik [a, b, c] tiap label (mis. agar “standar” lebih lebar):

```php
$mfAll = function (float $x) use ($tri): array {
    return [
        'sangat_kurang' => $tri($x, 0, 0, 20),
        'kurang'        => $tri($x, 10, 25, 45),
        'standar'       => $tri($x, 40, 60, 80),
        'baik'          => $tri($x, 70, 85, 95),
        'unggul'        => $tri($x, 90, 100, 100),
    ];
};
```

### 8.2 Tambah/Kurangi rule

Tambahkan blok perhitungan \( \alpha \) dan konstanta `y`:

```php
$α = min($μT['unggul'], max($μP['standar'], $μP['baik'], $μP['unggul']));
if ($α > 0) $rules[] = ['α' => $α, 'y' => 88];
```

### 8.3 Kalibrasi bobot fallback

Ubah skor label pada fallback bila kultur perusahaan berbeda:

```php
$score = function(array $μ) {
    return (35*$μ['sangat_kurang'] +
            55*$μ['kurang'] +
            75*$μ['standar'] +
            92*$μ['baik'] +
            100*$μ['unggul']) / max(1e-9, array_sum($μ));
};
```

---

## 9) Validasi & Debugging

-   Nilai harus 0–100.
-   Bila semua derajat keanggotaan **0**, periksa overlap membership.
-   Untuk debug aturan yang aktif:

```php
\Log::debug('Rules', $rules);
```

---

## 10) Integrasi UI

-   Tabel hasil: tampilkan skor fuzzy dan badge warna:
    -   `≥ 85`: Sangat Direkomendasikan
    -   `70–84`: Direkomendasikan
    -   `55–69`: Pertimbangan
    -   `< 55`: Tidak Direkomendasikan

```blade
<span class="{{ $z >= 85 ? 'bg-emerald-100 text-emerald-700' :
  ($z >= 70 ? 'bg-blue-100 text-blue-700' :
  ($z >= 55 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700')) }}">
  {{ $z }}
</span>
```

---

## 11) Keamanan & Kualitas Data

-   Validasi input numeric.
-   Rate-limit jika publik.
-   Gunakan pagination untuk dataset besar.

---

## 12) Ekstensi

-   Simpan rule & parameter MF ke database agar editable via UI.
-   Halaman simulasi input untuk melihat efek skor real-time.
-   Export laporan (CSV/PDF).
-   Audit trail.

---

## 13) Contoh Kode Penting

```php
$tri = function (float $x, float $a, float $b, float $c): float {
    if ($x <= $a || $x >= $c) return 0.0;
    if ($x == $b) return 1.0;
    return ($x < $b)
        ? ($x - $a) / max(1e-9, ($b - $a))
        : ($c - $x) / max(1e-9, ($c - $b));
};

$num = array_sum(array_map(fn($r) => $r['alpha'] * $r['y'], $rules));
$den = array_sum(array_column($rules, 'alpha'));
$fuzzy_score = $den > 0 ? round($num / $den, 2) : 0;
```
