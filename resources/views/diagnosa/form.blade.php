<x-app-layout title="Form Diagnosa">
    <x-slot name="heading">
        Form Diagnosa Penyakit Hewan
    </x-slot>

    <x-slot name="body">
        <div class="w-full px-6 py-6 mx-auto">
            <h1 class="text-xl font-semibold mb-2">
                {{ $page_meta['title'] ?? 'Form Diagnosa' }}
            </h1>
            <p class="text-gray-600 mb-4">
                {{ $page_meta['description'] ?? 'Silakan pilih gejala yang muncul pada hewan Anda dan berikan tingkat keyakinan Anda.' }}
            </p>

            {{-- Pesan Sukses --}}
            @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            {{-- Form Diagnosa --}}
            <form method="POST" action="{{ $page_meta['url'] ?? route('diagnosa.store') }}">
                @csrf
                @method($page_meta['method'] ?? 'POST')

                {{-- Nama Hewan --}}
                <div class="mb-4">
                    <label for="nama_hewan" class="block font-medium mb-1">Nama Hewan:</label>
                    <input type="text" id="nama_hewan" name="nama_hewan"
                        value="{{ old('nama_hewan') }}"
                        class="border rounded px-3 py-2 w-full sm:w-1/2 text-sm focus:ring focus:ring-blue-200"
                        placeholder="Masukkan nama hewan Anda" required>
                    @error('nama_hewan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Pencarian Gejala --}}
                <div class="mb-4">
                    <label for="search-gejala" class="block font-medium mb-1">Cari Gejala:</label>
                    <input type="text" id="search-gejala"
                        placeholder="Ketik untuk mencari gejala..."
                        class="border rounded px-3 py-2 w-full sm:w-1/2 text-sm focus:ring focus:ring-blue-200" />
                </div>

                {{-- Daftar Gejala --}}
                <div class="mb-4">
                    <label class="block font-medium mb-2">Daftar Gejala:</label>
                    <div class="bg-white border rounded shadow overflow-x-auto overflow-y-auto max-h-[400px]" id="table-wrapper">
                        <table class="w-full border text-sm">
                            <thead class="bg-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="border px-2 py-1 text-center w-16">Pilih</th>
                                    <th class="border px-2 py-1 text-left">Nama Gejala</th>
                                    <th class="border px-2 py-1 text-center w-32">Nilai CF</th>
                                    <th class="border px-2 py-1 text-center w-40">Tingkat Keyakinan</th>
                                </tr>
                            </thead>
                            <tbody id="gejala-table-body">
                                @forelse ($gejala as $item)
                                <tr class="hover:bg-gray-50">
                                    {{-- Checkbox Pilih Gejala --}}
                                    <td class="border px-2 py-1 text-center">
                                        <input type="checkbox" name="gejala[]" value="{{ $item->id }}" class="form-checkbox"
                                            @checked(is_array(old('gejala')) && in_array($item->id, old('gejala'))) />
                                    </td>

                                    {{-- Nama Gejala --}}
                                    <td class="border px-2 py-1 gejala-text">
                                        {{ $item->gejala }}
                                    </td>

                                    {{-- Nilai CF Manual --}}
                                    <td class="border px-2 py-1 text-center">
                                        <input type="number" step="0.01" min="0" max="1"
                                            name="cf_user[{{ $item->id }}]"
                                            id="cf-input-{{ $item->id }}"
                                            class="cf-input border rounded px-2 py-1 w-20 text-center focus:ring focus:ring-blue-200"
                                            value="{{ old('cf_user.' . $item->id, 0) }}"
                                            placeholder="0.0">
                                    </td>

                                    {{-- Quick Set Tingkat Keyakinan --}}
                                    <td class="border px-2 py-1 text-center">
                                        <select onchange="document.getElementById('cf-input-{{ $item->id }}').value = this.value"
                                            class="border rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
                                            <option value="">-- Pilih --</option>
                                            <option value="0.2">Sangat Tidak Yakin</option>
                                            <option value="0.4">Tidak Yakin</option>
                                            <option value="0.6">Cukup Yakin</option>
                                            <option value="0.8">Yakin</option>
                                            <option value="1.0">Sangat Yakin</option>
                                        </select>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">
                                        Belum ada data gejala.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @error('gejala')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="mt-6">
                    <x-button class="bg-blue-500 hover:bg-blue-600 text-white">
                        {{ $page_meta['button'] ?? 'Diagnosa Sekarang' }}
                    </x-button>
                </div>
            </form>
        </div>

        {{-- Script Pencarian Gejala --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-gejala');
                const rows = document.querySelectorAll('#gejala-table-body tr');

                searchInput.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase();
                    rows.forEach(row => {
                        const text = row.querySelector('.gejala-text').innerText.toLowerCase();
                        row.style.display = text.includes(keyword) ? '' : 'none';
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>