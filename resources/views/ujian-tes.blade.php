{{-- resources/views/ujian-tes.blade.php --}}
@php
    $jenisParam = $jenis ?? request()->route('jenis');
    $jenisLabel = $jenisParam ? ucfirst(str_replace('_', ' ', $jenisParam)) : '—';
@endphp

<x-layout :title="$title ?? 'Tes: ' . $jenisLabel">
    <div x-data="ujianPage('{{ route('ujian.submit', $jenisParam) }}')" class="container mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">
            Tes: {{ $jenisLabel }}
        </h1>

        @if ($soals->isEmpty())
            <div
                class="p-6 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01" />
                </svg>
                <p class="font-semibold">Belum ada pertanyaan untuk tes ini.</p>
                <p class="text-sm">Silakan hubungi admin jika ini tidak sesuai.</p>
            </div>
        @else
            <form id="form-ujian" @submit.prevent="submitForm($event)" class="space-y-6">
                @csrf

                {{-- Data peserta --}}
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full border rounded-lg px-3 py-2">
                        <template x-if="errors.nama">
                            <p class="text-sm text-red-600 mt-1" x-text="errors.nama"></p>
                        </template>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Usia <span class="text-red-500">*</span></label>
                        <input type="number" name="usia" value="{{ old('usia') }}" min="17" max="70"
                            required class="w-full border rounded-lg px-3 py-2">
                        <template x-if="errors.usia">
                            <p class="text-sm text-red-600 mt-1" x-text="errors.usia"></p>
                        </template>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border rounded-lg px-3 py-2">
                        <template x-if="errors.email">
                            <p class="text-sm text-red-600 mt-1" x-text="errors.email"></p>
                        </template>
                    </div>
                </div>

                {{-- Soal --}}
                <div class="space-y-6">
                    @foreach ($soals as $index => $soal)
                        @php $oldAnswer = old("jawaban.$soal->id"); @endphp

                        <div
                            class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-bold text-blue-600 dark:text-blue-300">Soal {{ $index + 1 }}</span>
                            </div>

                            <div class="mb-3 text-gray-900 dark:text-white">
                                @if (is_array($soal->pertanyaan))
                                    @foreach ($soal->pertanyaan as $p)
                                        <p class="mb-1">{{ \Illuminate\Support\Str::of($p)->squish() }}</p>
                                    @endforeach
                                @else
                                    <p>{{ \Illuminate\Support\Str::of($soal->pertanyaan)->squish() }}</p>
                                @endif
                            </div>

                            @if (is_array($soal->opsi))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach ($soal->opsi as $key => $opsi)
                                        @php
                                            $optKey = is_array($opsi) ? $opsi['key'] ?? $key : $key;
                                            $optText = is_array($opsi)
                                                ? $opsi['text'] ?? ($opsi['label'] ?? '')
                                                : $opsi;
                                            $inputId = "soal_{$soal->id}_{$optKey}";
                                        @endphp

                                        <label for="{{ $inputId }}"
                                            class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 cursor-pointer hover:border-blue-300 dark:hover:border-blue-400">
                                            <input id="{{ $inputId }}" type="radio"
                                                name="jawaban[{{ $soal->id }}]" value="{{ $optKey }}"
                                                class="form-radio" {{ $oldAnswer == $optKey ? 'checked' : '' }}
                                                {{ $loop->first ? 'required' : '' }}>
                                            <span class="select-none">{{ $optKey }}. {{ $optText }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">Opsi tidak tersedia.</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 text-center">
                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        :disabled="loading" x-text="loading ? 'Mengirim...' : 'Kirim Jawaban'">
                    </button>
                </div>
            </form>
        @endif

        {{-- MODAL HASIL (tanpa backdrop gelap tebal; ringan & modern) --}}
        <div x-show="result.open" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none" x-cloak>
            {{-- Backdrop tipis (bisa hilangkan bg-* jika tak ingin backdrop) --}}
            <div class="absolute inset-0 bg-black/20 pointer-events-auto" @click="closeModal()"></div>

            <div x-transition.scale
                class="relative pointer-events-auto w-full max-w-md mx-4 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-2xl p-6">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hasil Ujian</h3>
                    <button @click="closeModal()" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414 5.707 15.707a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-6xl font-extrabold text-blue-600" x-text="result.data.nilai_akhir ?? 0"></p>
                    <p class="mt-2 text-gray-700 dark:text-gray-300"
                        x-text="`Benar ${result.data.benar ?? 0} dari ${result.data.jumlah_soal ?? 0} soal`"></p>
                    <p class="mt-1 text-sm text-gray-500" x-text="result.data.message ?? 'Jawaban tersimpan.'"></p>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a :href="result.data.links?.kompetensi_teknis"
                        class="inline-flex justify-center items-center px-4 py-2 rounded-lg border bg-white hover:bg-gray-50 text-gray-700">
                        Tes Kompetensi Teknis
                    </a>
                    <a :href="result.data.links?.psikotes"
                        class="inline-flex justify-center items-center px-4 py-2 rounded-lg border bg-white hover:bg-gray-50 text-gray-700">
                        Tes Psikotes
                    </a>
                    <a :href="result.data.links?.kepribadian"
                        class="inline-flex justify-center items-center px-4 py-2 rounded-lg border bg-white hover:bg-gray-50 text-gray-700">
                        Tes Kepribadian
                    </a>
                    <a :href="result.data.links?.home"
                        class="inline-flex justify-center items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine helper --}}
    <script>
        function ujianPage(postUrl) {
            return {
                loading: false,
                errors: {},
                result: {
                    open: false,
                    data: {},
                },
                async submitForm(e) {
                    this.loading = true;
                    this.errors = {};
                    try {
                        const form = e.target;
                        const formData = new FormData(form);
                        const res = await fetch(postUrl, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });
                        if (!res.ok) {
                            // 422 validation
                            if (res.status === 422) {
                                const json = await res.json();
                                // ambil error pertama tiap field
                                this.errors = Object.fromEntries(
                                    Object.entries(json.errors || {}).map(([k, v]) => [k, v?.[0] ?? ''])
                                );
                            } else {
                                throw new Error('Gagal mengirim jawaban');
                            }
                            return;
                        }
                        const json = await res.json();
                        this.result.data = json;
                        this.result.open = true;
                        // optional: confetti ringan
                        // try { confetti && confetti(); } catch(e){}
                        form.reset();
                    } catch (err) {
                        alert(err.message || 'Terjadi kesalahan.');
                    } finally {
                        this.loading = false;
                    }
                },
                closeModal() {
                    this.result.open = false;
                }
            }
        }
    </script>
</x-layout>
