<x-layout :title="$title">
    {{-- Alpine untuk interaksi ringan --}}
    <div x-data="{ kbdHint: false }" class="container mx-auto py-10 px-4">

        {{-- HERO / Header --}}
        <section
            class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-gradient-to-br from-blue-50 via-indigo-50 to-emerald-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 p-8 md:p-10">
            <div class="flex flex-col md:flex-row gap-8 md:items-center">
                <div class="flex-1">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-white/70 dark:bg-white/10 text-blue-700 dark:text-blue-200 border border-blue-100 dark:border-white/10 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        Ujian Online Kandidat
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        Aturan & Panduan Ujian Online
                    </h1>
                    <p class="mt-3 text-gray-700 dark:text-gray-300 leading-relaxed">
                        Baca panduan di bawah ini, lalu pilih salah satu jenis tes untuk memulai. Setiap tes memiliki
                        durasi
                        dan jumlah soal tertentu. Pastikan perangkat dan internet stabil. Semoga sukses!
                    </p>

                    {{-- Quick stats --}}
                    @php
                        $tesStats = collect(\App\Models\TesOnline::select('jenis')->distinct()->pluck('jenis'))->map(
                            function ($jenis) {
                                $jumlah = \App\Models\TesOnline::where('jenis', $jenis)->count();
                                return [
                                    'jenis' => $jenis,
                                    'jumlah_soal' => $jumlah,
                                ];
                            },
                        );
                    @endphp
                    <div class="mt-5 grid grid-cols-3 gap-3 sm:max-w-lg">
                        <div
                            class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Tes</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $tesStats->count() }}
                            </p>
                        </div>
                        <div
                            class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Estimasi Waktu</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">± 45 menit</p>
                        </div>
                        <div
                            class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Format</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">Pilihan Ganda</p>
                        </div>
                    </div>
                </div>

                {{-- Ilustrasi / Panel tips --}}
                <div class="flex-1">
                    <div
                        class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800 p-5 backdrop-blur">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-3">Panduan Singkat</h3>
                        <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 inline-block w-2 h-2 rounded-full bg-blue-500"></span>
                                Kerjakan tes secara berurutan. Perhatikan timer di setiap tes.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                                Jangan buka tab lain atau gunakan bantuan pihak ketiga.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                                Kirim jawaban sebelum waktu habis. Jawaban yang terkirim tidak dapat diubah.
                            </li>
                        </ul>

                        {{-- Stepper alur ujian --}}
                        <div class="mt-5">
                            <ol class="relative border-s border-gray-200 dark:border-gray-700">
                                <li class="ms-4 mb-4">
                                    <div class="absolute w-2 h-2 rounded-full bg-blue-600 -start-[5px] top-2"></div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Pilih Tes</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Kompetensi Teknis → Psikotes →
                                        Kepribadian</p>
                                </li>
                                <li class="ms-4 mb-4">
                                    <div class="absolute w-2 h-2 rounded-full bg-indigo-600 -start-[5px] top-2"></div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Kerjakan & Kirim</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Jawab setiap soal dan pastikan
                                        menekan tombol <em>Kirim</em>.</p>
                                </li>
                                <li class="ms-4">
                                    <div class="absolute w-2 h-2 rounded-full bg-emerald-600 -start-[5px] top-2"></div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Selesai</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Tunggu pengumuman hasil pada
                                        halaman ini.</p>
                                </li>
                            </ol>
                        </div>
                    </div>

                    {{-- Hint keyboard --}}
                    <div class="mt-3 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <span @mouseenter="kbdHint = true" @mouseleave="kbdHint = false"
                            class="inline-flex items-center gap-1">
                            Tekan
                            <kbd
                                class="px-2 py-1 rounded border bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 font-semibold">/</kbd>
                            untuk fokus ke pencarian
                        </span>
                        <span x-cloak x-show="kbdHint" class="ml-auto">Tip: pakai <kbd
                                class="px-1 border rounded">Tab</kbd> untuk navigasi tombol.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- GRID kartu tes --}}
        <section class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card: Kompetensi Teknis --}}
            <article
                class="group relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm hover:shadow-lg transition-shadow">
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900/30 blur-2xl">
                </div>

                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Tes Kompetensi Teknis</h4>
                    <span
                        class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        {{ optional($tesStats->get('kompetensi_teknis'))->jumlah_soal ?? 0 }} soal • 15 mnt
                    </span>
                </div>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Mengukur pengetahuan & keterampilan teknis (logika, matematika, studi kasus).
                </p>

                {{-- Badge fitur --}}
                <div class="mt-4 flex flex-wrap gap-2">
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Pilihan
                        ganda</span>
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Timer
                        aktif</span>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('ujian.tes', ['jenis' => 'kompetensi_teknis']) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Mulai Tes
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Rekomendasi pertama</span>
                </div>
            </article>

            {{-- Card: Psikotes --}}
            <article
                class="group relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm hover:shadow-lg transition-shadow">
                <div
                    class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-purple-100 dark:bg-purple-900/30 blur-2xl">
                </div>

                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Tes Psikotes</h4>
                    <span
                        class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        {{ optional($tesStats->get('psikotes'))->jumlah_soal ?? 0 }} soal • 15 mnt
                    </span>
                </div>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Mengukur kemampuan kognitif, penalaran, dan pola pikir (analogi, pola, logika).
                </p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Pilihan
                        ganda</span>
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Timer
                        aktif</span>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('ujian.tes', ['jenis' => 'psikotes']) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        Mulai Tes
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Tingkatkan akurasi</span>
                </div>
            </article>

            {{-- Card: Kepribadian --}}
            <article
                class="group relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm hover:shadow-lg transition-shadow">
                <div
                    class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-emerald-100 dark:bg-emerald-900/30 blur-2xl">
                </div>

                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Tes Kepribadian</h4>
                    <span
                        class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        </svg>
                        {{ optional($tesStats->get('kepribadian'))->jumlah_soal ?? 0 }} soal • 15 mnt
                    </span>
                </div>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Menilai karakter, sikap kerja, dan preferensi perilaku dalam konteks pekerjaan.
                </p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Skala
                        Likert</span>
                    <span
                        class="text-[11px] px-2 py-1 rounded-full border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-600 dark:text-gray-300">Timer
                        aktif</span>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('ujian.tes', ['jenis' => 'kepribadian']) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-emerald-600 text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        Mulai Tes
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Cek kecocokan budaya</span>
                </div>
            </article>
        </section>

        {{-- Footer note --}}
        <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
            Dengan menekan “Mulai Tes”, Anda menyetujui ketentuan ujian yang berlaku.
        </p>
    </div>
</x-layout>
