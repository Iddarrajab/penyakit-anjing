<x-app-layout title="Aturan">
    <x-slot name="heading">
        Aturan
    </x-slot>

    <x-slot name="body">
        <div class="w-full px-6 py-6 mx-auto">
            {{-- Judul & Deskripsi --}}
            <h1 class="text-xl font-semibold mb-2">
                {{ $page_meta['title'] ?? 'Daftar Aturan' }}
            </h1>
            <p class="text-gray-600 mb-4">
                {{ $page_meta['description'] ?? 'Berikut daftar aturan yang menghubungkan penyakit dan gejala beserta nilai CF-nya.' }}
            </p>

            {{-- Tombol Tambah Aturan --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('aturan.create') }}">
                    <x-button class="bg-blue-500 hover:bg-blue-600 text-white">
                        + Tambah Aturan
                    </x-button>
                </a>
            </div>

            {{-- Tabel Aturan --}}
            <div class="bg-white border rounded shadow w-full mt-4 overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border border-gray-300">Kode</th>
                            <th class="px-3 py-2 border border-gray-300">Penyakit</th>
                            <th class="px-3 py-2 border border-gray-300 w-1/3">Gejala & CF</th>
                            <th class="px-3 py-2 border border-gray-300">Obat</th>
                            <th class="px-3 py-2 border border-gray-300">Solusi</th>
                            <th class="px-3 py-2 border border-gray-300">Tanggal</th>
                            <th class="px-3 py-2 border border-gray-300 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aturan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                {{ $item->code }}
                            </td>
                            <td class="px-3 py-2 border border-gray-300">
                                {{ $item->penyakit->penyakit ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border border-gray-300 break-words">
                                @if($item->gejala->count())
                                <ul class="list-disc list-inside">
                                    @foreach ($item->gejala as $gejala)
                                    <li>
                                        {{ $gejala->gejala ?? '-' }}
                                        (<span class="font-semibold">{{ number_format($gejala->pivot->cf, 2) }}</span>)
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <span class="text-gray-500">Tidak ada gejala</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 border border-gray-300">
                                {{ $item->penyakit->obat ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border border-gray-300">
                                {{ $item->penyakit->solusi ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                {{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                <div class="flex justify-center gap-x-3">
                                    <a href="{{ route('aturan.edit', $item) }}" class="text-yellow-600 hover:underline">
                                        Edit
                                    </a>
                                    <form action="{{ route('aturan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aturan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4 border border-gray-300">
                                Belum ada data aturan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-app-layout>