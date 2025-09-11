<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            {{ __('Hasil Seleksi Fuzzy') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
            <h3 class="text-lg font-bold mb-4">Tabel Hasil Seleksi Fuzzy</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border">Email</th>
                            <th class="px-3 py-2 border">Nilai Akademik</th>
                            <th class="px-3 py-2 border">Soft Skill</th>
                            <th class="px-3 py-2 border">Hasil Seleksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kandidats as $kandidat)
                            <tr>
                                <td class="px-3 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 border">{{ $kandidat->nama }}</td>
                                <td class="px-3 py-2 border">{{ $kandidat->email }}</td>
                                <td class="px-3 py-2 border">{{ $kandidat->nilai_akademik }}</td>
                                <td class="px-3 py-2 border">{{ $kandidat->soft_skill }}</td>
                                <td class="px-3 py-2 border font-semibold text-center">-</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data kandidat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
