<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            {{ isset($tesOnline) ? __('Edit Tes Online') : __('Buat Tes Online') }}
        </h2>
    </x-slot>

    @php
        /** @var \App\Models\TesOnline|null $tesOnline */
        $isEdit = isset($tesOnline);
        $action = $isEdit ? route('tes-online.update', $tesOnline) : route('tes-online.store');
    @endphp

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="form-tes-online" class="space-y-6">
        @csrf
        @if ($isEdit)
            @method('PATCH')
        @endif

        {{-- Flash success --}}
        @if (session('success'))
            <div class="p-3 rounded-lg bg-green-50 text-green-700 border border-green-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pilih jenis tes --}}
        <div>
            <label class="block text-sm font-medium mb-1">Jenis Tes <span class="text-red-500">*</span></label>
            <select name="jenis" class="w-full border rounded-lg px-3 py-2" required>
                @php $jenisVal = old('jenis', $tesOnline->jenis ?? ''); @endphp
                <option value="">Pilih jenis</option>
                <option value="kompetensi_teknis" {{ $jenisVal === 'kompetensi_teknis' ? 'selected' : '' }}>Kompetensi
                    Teknis</option>
                <option value="psikotes" {{ $jenisVal === 'psikotes' ? 'selected' : '' }}>Psikotes</option>
                <option value="kepribadian" {{ $jenisVal === 'kepribadian' ? 'selected' : '' }}>Kepribadian</option>
            </select>
            @error('jenis')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @php
            // Default aman kalau controller tidak mengirim variabel
            $tesOnline = $tesOnline ?? null; // boleh null
            $isEdit = $isEdit ?? false; // create: false, edit: true
        @endphp

        {{-- Pertanyaan --}}
        <fieldset class="border rounded-lg p-4">
            <legend class="px-2 text-sm font-semibold">Pertanyaan</legend>

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Tipe Konten <span class="text-red-500">*</span></label>
                @php
                    $pType = old('pertanyaan.type', data_get($tesOnline, 'pertanyaan.type', 'text'));
                @endphp
                <select name="pertanyaan[type]" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="text" {{ $pType === 'text' ? 'selected' : '' }}>Teks</option>
                    <option value="image" {{ $pType === 'image' ? 'selected' : '' }}>Gambar</option>
                    <option value="mixed" {{ $pType === 'mixed' ? 'selected' : '' }}>Gabungan (teks + gambar)</option>
                </select>
                @error('pertanyaan.type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Teks Pertanyaan</label>
                    <textarea name="pertanyaan[text]" rows="3" class="w-full border rounded-lg px-3 py-2"
                        placeholder="Tulis pertanyaan...">{{ old('pertanyaan.text', data_get($tesOnline, 'pertanyaan.text')) }}</textarea>
                    @error('pertanyaan.text')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gambar Pertanyaan (upload)</label>
                    <input type="file" name="pertanyaan[image_file]" accept="image/*"
                        class="w-full border rounded-lg px-3 py-2">
                    <p class="text-xs text-gray-500 mt-1">Atau isi URL gambar:</p>
                    <input type="url" name="pertanyaan[image]"
                        value="{{ old('pertanyaan.image', data_get($tesOnline, 'pertanyaan.image')) }}"
                        class="w-full border rounded-lg px-3 py-2" placeholder="https://...">
                    @error('pertanyaan.image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @if ($isEdit && data_get($tesOnline, 'pertanyaan.image'))
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 mb-1">Preview gambar saat ini:</p>
                            <img src="{{ \Illuminate\Support\Str::startsWith(data_get($tesOnline, 'pertanyaan.image'), ['http://', 'https://']) ? data_get($tesOnline, 'pertanyaan.image') : Storage::url(data_get($tesOnline, 'pertanyaan.image')) }}"
                                alt="Pertanyaan" class="max-h-40 rounded">
                        </div>
                    @endif
                </div>
            </div>
        </fieldset>

        {{-- Opsi Jawaban --}}
        <fieldset class="border rounded-lg p-4">
            <legend class="px-2 text-sm font-semibold">Opsi Jawaban</legend>

            <div id="opsi-container" class="space-y-4">
                {{-- Template opsi akan dikloning via JS --}}
            </div>

            <div class="mt-3">
                <button type="button" id="btn-add-opsi"
                    class="bg-blue-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-blue-700">
                    + Tambah Opsi
                </button>
                <span class="text-xs text-gray-500 ml-2">Minimal 2 opsi. Centang checkbox untuk menandai jawaban benar
                    (bisa lebih dari satu).</span>
            </div>
        </fieldset>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('tes-online.index') }}" class="text-gray-700 hover:underline">Kembali</a>
        </div>

        {{-- Error global --}}
        @if ($errors->any())
            <div class="text-red-700 bg-red-50 border border-red-200 rounded-lg p-3 text-sm">
                <strong>Periksa kembali input Anda:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    {{-- Template HTML tersembunyi untuk satu opsi --}}
    <template id="opsi-template">
        <div class="border rounded-lg p-3 relative">
            <button type="button"
                class="btn-remove-opsi absolute top-2 right-2 text-red-600 text-xs hover:underline">Hapus</button>
            <div class="grid sm:grid-cols-12 gap-3 items-start">
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium mb-1">Key</label>
                    <input type="text" class="opsi-key w-full border rounded-lg px-2 py-2 bg-gray-100" name=""
                        value="" readonly>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium mb-1">Tipe</label>
                    <select class="opsi-type w-full border rounded-lg px-2 py-2" name="">
                        <option value="text">Teks</option>
                        <option value="image">Gambar</option>
                        <option value="mixed">Gabungan</option>
                    </select>
                </div>
                <div class="sm:col-span-4">
                    <label class="block text-sm font-medium mb-1">Teks Opsi</label>
                    <input type="text" class="opsi-text w-full border rounded-lg px-2 py-2" name=""
                        placeholder="Isi teks (opsional)">
                </div>
                <div class="sm:col-span-4">
                    <label class="block text-sm font-medium mb-1">Gambar Opsi</label>
                    <input type="file" class="opsi-image-file w-full border rounded-lg px-2 py-2" name=""
                        accept="image/*">
                    <input type="url" class="opsi-image-url w-full border rounded-lg px-2 py-2 mt-2" name=""
                        placeholder="atau URL https://...">
                </div>
                <div class="sm:col-span-12">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" class="opsi-correct accent-green-600" name="" value="">
                        <span>Tandai sebagai jawaban benar</span>
                    </label>
                </div>
            </div>
        </div>
    </template>

    <script>
        (function() {
            const container = document.getElementById('opsi-container');
            const tpl = document.getElementById('opsi-template');
            const addBtn = document.getElementById('btn-add-opsi');

            // Data awal: prioritaskan old(); jika edit, pakai data model
            const existingOpsi = @json(old('opsi', $tesOnline->opsi ?? []));
            const existingJawaban = @json(old('jawaban_benar', $tesOnline->jawaban_benar ?? []));
            const isEdit = @json($isEdit);

            function nextKey(index) {
                // 0 -> A, 1 -> B, ..., 25 -> Z, 26 -> AA
                let n = index,
                    s = '';
                while (true) {
                    s = String.fromCharCode(65 + (n % 26)) + s;
                    n = Math.floor(n / 26) - 1;
                    if (n < 0) break;
                }
                return s;
            }

            function rebuildNames() {
                const items = container.querySelectorAll('[data-opsi]');
                items.forEach((el, idx) => {
                    const key = nextKey(idx);
                    el.querySelector('.opsi-key').value = key;
                    el.querySelector('.opsi-key').setAttribute('name', `opsi[${idx}][key]`);
                    el.querySelector('.opsi-type').setAttribute('name', `opsi[${idx}][type]`);
                    el.querySelector('.opsi-text').setAttribute('name', `opsi[${idx}][text]`);
                    el.querySelector('.opsi-image-file').setAttribute('name', `opsi[${idx}][image_file]`);
                    el.querySelector('.opsi-image-url').setAttribute('name', `opsi[${idx}][image]`);
                    const cb = el.querySelector('.opsi-correct');
                    cb.setAttribute('name', 'jawaban_benar[]');
                    cb.value = key;
                });
            }

            function addOpsi(data = null) {
                const node = tpl.content.cloneNode(true);
                const wrapper = document.createElement('div');
                wrapper.setAttribute('data-opsi', '');
                wrapper.appendChild(node);
                container.appendChild(wrapper);
                rebuildNames();

                const idx = [...container.querySelectorAll('[data-opsi]')].indexOf(wrapper);
                const key = nextKey(idx);

                if (data) {
                    wrapper.querySelector('.opsi-type').value = data.type ?? 'text';
                    wrapper.querySelector('.opsi-text').value = data.text ?? '';
                    wrapper.querySelector('.opsi-image-url').value = data.image ?? '';
                }

                if (existingJawaban.includes(key)) {
                    wrapper.querySelector('.opsi-correct').checked = true;
                }

                wrapper.querySelector('.btn-remove-opsi').addEventListener('click', () => {
                    wrapper.remove();
                    rebuildNames();
                });
            }

            addBtn.addEventListener('click', () => addOpsi());

            // Inisialisasi:
            if (existingOpsi.length > 0) {
                existingOpsi.forEach(o => addOpsi(o));
            } else {
                addOpsi({
                    type: 'text'
                });
                addOpsi({
                    type: 'text'
                });
            }
        })();
    </script>
</x-app-layout>
