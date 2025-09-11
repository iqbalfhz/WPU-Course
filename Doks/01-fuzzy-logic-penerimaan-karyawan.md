# Dokumentasi Sistem Fuzzy Logic Penerimaan Karyawan Academy

## 1. Latar Belakang

Sistem ini dirancang untuk membantu proses seleksi penerimaan karyawan baru berbasis academy dengan menggunakan metode Fuzzy Logic Sugeno/Sukamoto. Metode ini dipilih karena mampu menangani ketidakpastian dan memberikan penilaian yang lebih fleksibel serta objektif.

## 2. Variabel Input

Setiap variabel input memiliki 5 himpunan fuzzy:

-   Sangat Tidak Layak
-   Tidak Layak
-   Dipertimbangkan
-   Layak
-   Sangat Layak

### Daftar Variabel Input:

1. **Nilai Akademik** (misal: IPK, nilai rata-rata)
2. **Tes Kompetensi Teknis** (tes bidang sesuai posisi yang dilamar)
3. **Tes Psikotes** (soal-soal psikologi untuk mengukur kepribadian, logika, dan kecerdasan emosional)
4. **Tes Kepribadian** (soal untuk mengukur karakter, motivasi, dan integritas)
5. **Soft Skill** (kerjasama tim, kepemimpinan, inisiatif)

#### Catatan Pengambilan Data Input:

-   **Nilai Akademik** dan **Soft Skill** diinput secara manual oleh admin/panitia melalui form khusus di dashboard/admin. Data ini bisa berasal dari dokumen resmi (transkrip, hasil observasi, dsb).
-   **Tes Kompetensi Teknis**, **Tes Psikotes**, dan **Tes Kepribadian** diambil otomatis dari hasil pengerjaan soal/kuis online oleh kandidat di landing-page.

Setiap data input harus divalidasi agar sesuai standar (misal: range nilai 0–100, format angka, dsb).

## 3. Variabel Output

Output sistem juga memiliki 5 himpunan fuzzy:

-   Sangat Tidak Layak
-   Tidak Layak
-   Dipertimbangkan
-   Layak
-   Sangat Layak

Setiap kategori output diwakili oleh nilai crisp (misal: 20, 40, 60, 80, 100) untuk proses defuzzifikasi.

## 4. Membership Function

Setiap variabel input dan output menggunakan membership function berbentuk segitiga atau trapesium, dengan range nilai disesuaikan dengan data aktual (misal: 0–100).

## 5. Rule Base Fuzzy

Aturan fuzzy (rule base) dibuat berdasarkan kombinasi himpunan fuzzy dari setiap input, misal:

-   Jika Nilai Akademik = Layak DAN Tes Kompetensi = Dipertimbangkan DAN Wawancara = Layak, maka Output = Layak
-   Jika semua input = Sangat Tidak Layak, maka Output = Sangat Tidak Layak

Jumlah rule dapat disesuaikan dengan kebutuhan dan kebijakan seleksi.

## 6. Proses Fuzzy Sugeno/Sukamoto

1. Fuzzifikasi: Mengubah nilai input ke derajat keanggotaan pada masing-masing himpunan fuzzy.
2. Inferensi: Menentukan rule yang aktif dan menghitung output crisp untuk setiap rule.
3. Defuzzifikasi: Menghitung weighted average dari semua output rule untuk mendapatkan nilai akhir.

## 7. Implementasi di Laravel

-   Struktur class FuzzyLogic diletakkan di `app/Services`.
-   Proses fuzzy dapat dipanggil dari controller saat melakukan penilaian seleksi.
-   Data input diambil dari form atau database, hasil output disimpan atau ditampilkan sesuai kebutuhan.

### Detail CRUD Data Input Manual

1. **Form Input Manual**

    - Disediakan di dashboard/admin untuk mengisi Nilai Akademik dan Soft Skill setiap kandidat.
    - Form dilengkapi validasi (misal: nilai 0–100, wajib diisi).
    - Data disimpan ke database (tabel kandidat atau tabel khusus input manual).

2. **Edit & Update Data**

    - Admin dapat mengedit data input manual jika ada koreksi atau perubahan.
    - Setiap perubahan dicatat (opsional: log perubahan).

3. **Integrasi Data**

    - Data input manual digabungkan dengan hasil tes otomatis untuk proses fuzzy logic.
    - Proses pengambilan data dilakukan di controller/service sebelum pemrosesan fuzzy.

4. **Validasi & Keamanan**

    - Pastikan hanya admin yang dapat mengakses dan mengubah data input manual.
    - Terapkan validasi backend dan frontend.

5. **Visualisasi & Output**
    - Hasil akhir fuzzy logic dapat ditampilkan di dashboard admin atau dikirim ke kandidat.
    - Sediakan fitur ekspor/unduh hasil seleksi (opsional).

## 8. Saran Pengembangan

-   Tambahkan interface untuk input data dan visualisasi hasil fuzzy.
-   Lakukan evaluasi dan penyesuaian membership function serta rule base secara berkala.

### Pengembangan Lanjutan

-   Otomatisasi import data dari sistem eksternal jika diperlukan.
-   Penambahan notifikasi untuk admin jika ada data yang belum lengkap.
-   Audit trail/log perubahan data input manual.
-   Penyesuaian membership function dan rule base berdasarkan evaluasi hasil seleksi.

---

Dokumentasi ini dapat dikembangkan sesuai kebutuhan dan perkembangan sistem.
