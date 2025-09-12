# Dokumentasi Update Fuzzy Sugeno Seleksi Karyawan

## 1. Alur Proses

1. **Input (Variabel Crisp):**
    - Nilai Akademik, Tes Kompetensi Teknis, Tes Psikotes, Tes Kepribadian, Soft Skill (skala 0–100).
2. **Fuzzifikasi (Membership Function):**
    - Setiap input dikategorikan ke: Sangat Kurang (0–34), Kurang (35–59), Standar (60–74), Baik (75–89), Unggul (90–100).
    - Derajat keanggotaan dihitung dengan fungsi linear pada setiap interval.
3. **Rule Base (Aturan Fuzzy Kompleks):**
    - Terdapat 9 aturan IF-THEN yang menggabungkan berbagai kombinasi kategori input.
    - Contoh: IF semua input Unggul THEN Output = 100, IF ≥2 input Kurang/Sangat Kurang THEN Output = 50, dst.
4. **Inferensi (Fire Strength/αi):**
    - Untuk setiap aturan, fire strength dihitung sebagai minimum derajat keanggotaan input pada aturan tersebut.
5. **Hitung Output Tiap Rule (yi):**
    - Output tiap aturan berupa nilai konstan (misal: 100, 90, dst).
6. **Agregasi & Defuzzifikasi (Weighted Average):**
    - Output akhir dihitung dengan rumus Sugeno: Output = Σ(αi × yi) / Σαi
    - Jika tidak ada aturan aktif, fallback ke rata-rata kategori.
7. **Output:**
    - Skor seleksi akhir (0–100) digunakan untuk ranking dan keputusan penerimaan.

## 2. Perubahan Kode

-   Controller `FuzzySeleksiController` diubah untuk mengimplementasikan alur fuzzy Sugeno lengkap dan kompleks.
-   Fungsi keanggotaan dan aturan fuzzy diatur sesuai rentang dan logika yang didiskusikan.
-   Skor akhir lebih adaptif dan realistis sesuai kombinasi input kandidat.

## 3. Catatan

-   Bobot aturan dan output dapat disesuaikan sesuai kebutuhan seleksi.
-   Dokumentasi ini mengikuti perubahan per 12 September 2025.

---

_Dokumen ini mencatat perubahan besar pada logika seleksi fuzzy Sugeno di sistem penerimaan karyawan._
