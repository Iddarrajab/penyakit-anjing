<x-app-layout title="gejala">
    <x-slot name="heading">
        Gejala
    </x-slot>

    <x-slot name="body">
        <div class="w-full px-6 py-6 mx-auto">
            {{-- Judul & Deskripsi --}}
            <h1 class="text-xl font-semibold mb-2">
                {{ $page_meta['title'] ?? 'Daftar Gejala' }}
            </h1>
            <p class="text-gray-600 mb-4">
                {{ $page_meta['description'] ?? 'Daftar semua gejala yang sudah dimasukkan admin.' }}
            </p>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('gejala.create') }}">
                    <x-button class="bg-blue-500 hover:bg-blue-600 text-white">
                        + Tambah Gejala
                    </x-button>
                </a>
            </div>

            {{-- Table Wrapper with Fixed Horizontal Scroll --}}
            <div class="mt-4 border rounded bg-white overflow-hidden">
                <div class="relative">
                    <div class="overflow-y-auto max-h-[400px] sm:max-h-[500px]">
                        <div class="overflow-x-auto" style="max-width: 100%;">
                            <table class="w-full min-w-[800px] sm:min-w-[1200px] text-xs sm:text-sm text-left border border-gray-200">
                                <thead class="bg-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-3 py-2 border">Code</th>
                                        <th class="px-3 py-2 border">Gejala</th>
                                        <th class="px-3 py-2 border">Tanggal</th>
                                        <th class="px-3 py-2 border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($gejala as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 border">{{ $item->code }}</td>
                                        <td class="px-3 py-2 border">{{ $item->gejala }}</td>
                                        <td class="px-3 py-2 border text-center">
                                            {{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="px-3 py-2 border text-center">
                                            <form action="{{ route('gejala.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                            <a href="{{ route('gejala.edit', $item) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500 py-4 border">
                                            Belum ada data gejala.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
    </x-slot>
</x-app-layout>