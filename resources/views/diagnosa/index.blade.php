<x-app-layout title="Diagnosa">
    <x-slot name="heading">
        Hasil Diagnosa Penyakit Hewan
    </x-slot>

    <x-slot name="body">
        <div class="w-full px-6 py-6 mx-auto">

            {{-- Judul & Deskripsi --}}
            <h1 class="text-xl font-semibold mb-2">Hasil Diagnosa</h1>
            <p class="text-gray-600 mb-4">
                Berikut hasil diagnosa penyakit hewan berdasarkan input gejala dan perhitungan metode <strong>Decision Tree</strong> serta <strong>Certainty Factor</strong>.
            </p>

            {{-- Input pencarian --}}
            <div class="mb-4">
                <input
                    type="text"
                    id="search-nama_hewan"
                    placeholder="Cari berdasarkan nama hewan..."
                    class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            {{-- Tabel hasil diagnosa --}}
            <div class="bg-white border rounded shadow overflow-x-auto w-full mt-4">
                <table class="w-full border text-sm border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border text-center">No</th>
                            <th class="px-3 py-2 border text-left">Nama Pengguna</th>
                            <th class="px-3 py-2 border text-left">Nama Hewan</th>
                            <th class="px-3 py-2 border text-left">Penyakit</th>
                            <th class="px-3 py-2 border text-center">Hasil Diagnosa (CF)</th>
                            <th class="px-3 py-2 border text-left">Obat</th>
                            <th class="px-3 py-2 border text-left">Solusi</th>
                            <th class="px-3 py-2 border text-center">Tanggal</th>
                            @if(Auth::guard('admin')->check())
                            <th class="px-3 py-2 border text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hasil as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2 border">{{ $item['user'] ?? '-' }}</td>
                            <td class="px-3 py-2 border">{{ $item['nama_hewan'] ?? '-' }}</td>
                            <td class="px-3 py-2 border">{{ $item['penyakit'] ?? '-' }}</td>
                            <td class="px-3 py-2 border text-center">
                                @php
                                $cf = $item['cf'];
                                if ($cf <= -1.0) {
                                    $frase='Pasti Tidak' ;
                                    } elseif ($cf <=-0.8) {
                                    $frase='Hampir Pasti Tidak' ;
                                    } elseif ($cf <=-0.6) {
                                    $frase='Kemungkinan Besar Tidak' ;
                                    } elseif ($cf <=-0.4) {
                                    $frase='Mungkin Tidak' ;
                                    } elseif ($cf> -0.2 && $cf < 0.2) {
                                        $frase='Tidak Tahu' ;
                                        } elseif ($cf>= 0.4 && $cf < 0.6) {
                                            $frase='Mungkin' ;
                                            } elseif ($cf>= 0.6 && $cf < 0.8) {
                                                $frase='Kemungkinan Besar' ;
                                                } elseif ($cf>= 0.8 && $cf < 1.0) {
                                                    $frase='Hampir Pasti' ;
                                                    } elseif ($cf==1.0) {
                                                    $frase='Pasti' ;
                                                    } else {
                                                    $frase='-' ;
                                                    }
                                                    @endphp
                                                    <span class="font-medium text-blue-600">{{ $frase }}</span>
                                                    <br>
                                                    <span class="text-gray-600">(CF: {{ number_format($cf, 2) }})</span>
                            </td>
                            <td class="px-3 py-2 border">{{ $item['obat'] ?? '-' }}</td>
                            <td class="px-3 py-2 border">{{ $item['solusi'] ?? '-' }}</td>
                            <td class="px-3 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d F Y, H:i') }}
                            </td>

                            @if(Auth::guard('admin')->check())
                            <td class="px-3 py-2 border text-center">
                                <form action="{{ route('diagnosa.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::guard('admin')->check() ? 9 : 8 }}" class="text-center text-gray-500 py-4 border">
                                Belum ada data diagnosa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Script pencarian nama hewan --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-nama_hewan');
                const rows = document.querySelectorAll('tbody tr');

                searchInput?.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase();
                    rows.forEach(row => {
                        const namaHewan = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                        row.style.display = namaHewan.includes(keyword) ? '' : 'none';
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>