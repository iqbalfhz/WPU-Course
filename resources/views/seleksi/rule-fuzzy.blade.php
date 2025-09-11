<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            {{ __('Pengaturan Rule Fuzzy') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Daftar Rule Fuzzy</h3>
                <a href="#" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah Rule</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">IF Nilai Akademik</th>
                            <th class="px-3 py-2 border">AND Soft Skill</th>
                            <th class="px-3 py-2 border">THEN Hasil</th>
                            <th class="px-3 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rules as $rule)
                            <tr>
                                <td class="px-3 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 border">{{ $rule->akademik_label }}</td>
                                <td class="px-3 py-2 border">{{ $rule->softskill_label }}</td>
                                <td class="px-3 py-2 border font-semibold">{{ $rule->hasil_label }}</td>
                                <td class="px-3 py-2 border text-center">
                                    <a href="#" class="text-blue-600 hover:underline mr-2">Edit</a>
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Yakin hapus rule ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada rule fuzzy.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
