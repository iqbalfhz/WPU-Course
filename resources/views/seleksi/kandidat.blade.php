<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            {{ __('Data Kandidat') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 px-4">
        {{-- Bar atas --}}
        <div class="mb-4 flex flex-col sm:flex-row gap-3 sm:gap-4 sm:items-center sm:justify-between">
            <!-- Modal toggle -->
            <div class="flex justify-center m-5">
                <button id="defaultModalButton" data-modal-target="defaultModal" data-modal-toggle="defaultModal"
                    class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    type="button">
                    Buat Kandidat
                </button>
                @if (session('success'))
                    <span class="text-green-600">{{ session('success') }}</span>
                @endif
            </div>

            {{-- (Opsional) Search --}}
            <form method="GET" action="{{ route('kandidat.index') }}" class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/email…"
                    class="w-64 max-w-full border rounded pl-9 pr-3 py-2">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" viewBox="0 0 24 24"
                    fill="none">
                    <path d="M21 21l-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" />
                </svg>
            </form>
        </div>

        {{-- Kartu tabel (sticky header + scroll) --}}
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
            <div class="overflow-x-auto">
                <div class="max-h-[60vh] overflow-y-auto rounded border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                            <tr class="text-left text-gray-700 dark:text-gray-100">
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Usia</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Nilai Akademik</th>
                                <th class="px-4 py-3">Tes Kompetensi Teknis</th>
                                <th class="px-4 py-3">Tes Psikotes</th>
                                <th class="px-4 py-3">Tes Kepribadian</th>
                                <th class="px-4 py-3">Soft Skill</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($kandidats as $kandidat)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-2">{{ $kandidat->nama }}</td>
                                    <td class="px-4 py-2">{{ $kandidat->usia }}</td>
                                    <td class="px-4 py-2">
                                        <a href="mailto:{{ $kandidat->email }}" class="text-blue-600 hover:underline">
                                            {{ $kandidat->email }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">{{ $kandidat->nilai_akademik }}</td>
                                    <td class="px-4 py-2">{{ $kandidat->tes_kompetensi_teknis }}</td>
                                    <td class="px-4 py-2">{{ $kandidat->tes_psikotes }}</td>
                                    <td class="px-4 py-2">{{ $kandidat->tes_kepribadian }}</td>
                                    <td class="px-4 py-2">{{ $kandidat->soft_skill }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <a href="{{ route('kandidat.edit', $kandidat) }}"
                                                class="text-yellow-600 hover:underline">Edit</a>
                                            <form action="{{ route('kandidat.destroy', $kandidat) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-6 text-gray-500">Belum ada data kandidat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination di luar area scroll --}}
            <div class="mt-4">
                {{ $kandidats->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div
                    class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tambah Kandidat
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('kandidat.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nama
                            </label>
                            <input type="text" name="nama" id="nama" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Nama kandidat">
                        </div>
                        <div>
                            <label for="usia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Usia
                            </label>
                            <input type="number" name="usia" id="usia" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Usia kandidat">
                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email" name="email" id="email" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Email kandidat">
                        </div>
                        <div>
                            <label for="nilai_akademik"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nilai Akademik
                            </label>
                            <input type="text" name="nilai_akademik" id="nilai_akademik"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Nilai akademik">
                        </div>
                        <div>
                            <label for="tes_kompetensi_teknis"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tes Kompetensi Teknis
                            </label>
                            <input type="text" name="tes_kompetensi_teknis" id="tes_kompetensi_teknis"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Nilai tes teknis">
                        </div>
                        <div>
                            <label for="tes_psikotes"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tes Psikotes
                            </label>
                            <input type="text" name="tes_psikotes" id="tes_psikotes"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Nilai psikotes">
                        </div>
                        <div>
                            <label for="tes_kepribadian"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tes Kepribadian
                            </label>
                            <input type="text" name="tes_kepribadian" id="tes_kepribadian"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Nilai kepribadian">
                        </div>
                        <div>
                            <label for="soft_skill"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Soft Skill
                            </label>
                            <input type="text" name="soft_skill" id="soft_skill"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Soft skill kandidat">
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Simpan Kandidat
                    </button>
                </form>
            </div>
        </div>
    </div>




</x-app-layout>
