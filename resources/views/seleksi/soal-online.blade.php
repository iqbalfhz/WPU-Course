<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            Daftar Soal Online
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-2">
            <form method="GET" action="{{ route('soal-online.index') }}" class="flex gap-2">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari pertanyaan..."
                    class="border rounded px-3 py-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cari</button>
            </form>
            <a href="{{ route('tes-online.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tambah Soal</a>
            @if (session('success'))
                <span class="text-green-600">{{ session('success') }}</span>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                        <th class="px-4 py-3 text-center font-semibold">Jenis Tes</th>
                        <th class="px-4 py-3 text-center font-semibold">Pertanyaan</th>
                        <th class="px-4 py-3 text-center font-semibold">Opsi Jawaban</th>
                        <th class="px-4 py-3 text-center font-semibold">Jawaban Benar</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($soals as $soal)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-900">
                            {{-- Jenis --}}
                            <td class="px-4 py-3 align-top text-center">
                                {{ !empty($soal->jenis) ? ucfirst(str_replace('_', ' ', $soal->jenis)) : '—' }}
                            </td>

                            {{-- Pertanyaan (tanpa enter berlebih) --}}
                            <td class="px-4 py-3 align-top">
                                @php
                                    $pText = null;
                                    $pImage = null;
                                    if (!empty($soal->pertanyaan)) {
                                        if (is_array($soal->pertanyaan)) {
                                            $pText = \Illuminate\Support\Str::of(
                                                $soal->pertanyaan['text'] ?? '',
                                            )->squish();
                                            $pImage = $soal->pertanyaan['image'] ?? null;
                                        } else {
                                            $pText = \Illuminate\Support\Str::of($soal->pertanyaan)->squish();
                                        }
                                    }
                                @endphp

                                @if ($pText || $pImage)
                                    <div class="flex flex-col items-start space-y-2">
                                        @if ($pText)
                                            <span class="font-medium break-words">{{ $pText }}</span>
                                        @endif
                                        @if ($pImage)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($pImage, ['http://', 'https://']) ? $pImage : \Illuminate\Support\Facades\Storage::url($pImage) }}"
                                                alt="Gambar pertanyaan"
                                                class="max-h-32 w-auto rounded object-cover border mx-auto">
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Opsi --}}
                            <td class="px-4 py-3 align-top">
                                @if (!empty($soal->opsi) && is_array($soal->opsi))
                                    <ul class="list-disc list-inside pl-4 space-y-1 m-0">
                                        @foreach ($soal->opsi as $opsi)
                                            @php
                                                $oKey = $opsi['key'] ?? '—';
                                                $oTxt = \Illuminate\Support\Str::of($opsi['text'] ?? '')->squish();
                                                $oImg = $opsi['image'] ?? null;
                                            @endphp
                                            <li class="leading-6">
                                                <span class="font-semibold">{{ $oKey }}.</span>
                                                <span>{{ $oTxt ?: '—' }}</span>
                                                @if ($oImg)
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($oImg, ['http://', 'https://']) ? $oImg : \Illuminate\Support\Facades\Storage::url($oImg) }}"
                                                        alt="Gambar opsi" class="max-h-16 rounded mt-1 inline-block">
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif(!empty($soal->opsi))
                                    <span
                                        class="break-words">{{ \Illuminate\Support\Str::of($soal->opsi)->squish() }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Jawaban Benar --}}
                            <td class="px-4 py-3 align-top text-center font-semibold">
                                @if (!empty($soal->jawaban_benar))
                                    {{ is_array($soal->jawaban_benar) ? implode(', ', $soal->jawaban_benar) : $soal->jawaban_benar }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3 align-top text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('tes-online.edit', $soal) }}"
                                        class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('tes-online.destroy', $soal) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada soal tes online.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $soals->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
