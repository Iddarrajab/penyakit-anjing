<x-app-layout tittle="Penyakit">
    <x-slot name="heading">
        Penyakit
    </x-slot>

    <x-slot name="body">

        <h1 class="text-lg sm:text-xl font-semibold mb-2">
            {{ $page_meta['title'] ?? 'Daftar Penyakit' }}
        </h1>
        <p class="text-sm sm:text-base text-gray-600 mb-4">
            {{ $page_meta['description'] ?? 'Daftar semua penyakit yang sudah dimasukkan admin.' }}
        </p>

        <div class="mt-4 sm:mt-6 flex justify-end">
            <a href="{{ route('penyakit.create') }}">
                <x-button class="bg-blue-500 hover:bg-blue-600 text-white text-sm sm:text-base px-3 sm:px-4 py-2">
                    + Tambah Penyakit
                </x-button>
            </a>
        </div>

        <div class="mt-4 border rounded bg-white overflow-hidden">
            <div class="relative">
                <div class="overflow-y-auto max-h-[400px] sm:max-h-[500px]">
                    <div class="overflow-x-auto" style="max-width: 100%;">
                        <table class="w-full min-w-[800px] sm:min-w-[1200px] text-xs sm:text-sm text-left border border-gray-200">
                            <thead class="bg-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Kode</th>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Penyakit</th>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Solusi</th>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Obat</th>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Tanggal</th>
                                    <th class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penyakit as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm whitespace-nowrap">{{ $item->code }}</td>
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm">{{ $item->penyakit }}</td>
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm">{{ $item->solusi }}</td>
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm">{{ $item->obat }}</td>
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm text-center whitespace-nowrap">
                                        {{ $item->created_at?->format('d-m-Y') }}
                                    </td>
                                    <td class="px-2 sm:px-3 py-2 border text-xs sm:text-sm text-center whitespace-nowrap">
                                        <form action="{{ route('penyakit.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                        <a href="{{ route('penyakit.edit', $item) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>