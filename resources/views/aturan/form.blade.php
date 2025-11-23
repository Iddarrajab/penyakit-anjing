<x-app-layout title="{{ $page_meta['title'] }}">
    <x-slot name="heading">{{ $page_meta['title'] }}</x-slot>

    <x-slot name="body">
        <div class="px-6 py-10 mx-auto">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ $page_meta['url'] }}">
                @csrf
                @if ($page_meta['method'] === 'PUT')
                @method('PUT')
                @endif

                {{-- Kode Aturan --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kode Aturan</label>
                    <input type="text" name="code" value="{{ old('code', $aturan->code ?? '') }}" required
                        class="border rounded px-3 py-2 w-full">
                    @error('code')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>

                {{-- Penyakit --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Pilih Penyakit</label>
                    <select name="penyakit_id" class="border rounded px-3 py-2 w-full" required>
                        <option value="">-- Pilih Penyakit --</option>
                        @foreach($penyakitList as $p)
                        <option value="{{ $p->id }}" {{ old('penyakit_id', $aturan->penyakit_id ?? '') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_penyakit ?? $p->penyakit ?? '-' }}
                        </option>
                        @endforeach
                    </select>
                    @error('penyakit_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>

                {{-- Gejala dan Nilai CF --}}
                <div class="mb-4">
                    <label class="block font-medium mb-2">Daftar Gejala dan Nilai CF</label>
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1 text-center">Pilih</th>
                                <th class="border px-2 py-1 text-left">Gejala</th>
                                <th class="border px-2 py-1 text-center">Nilai CF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gejalaList as $g)
                            @php
                            $selected = in_array($g->id, old('gejala_ids', $aturan->gejala->pluck('id')->toArray() ?? []));
                            $cf_value = old('cf.'.$g->id, $aturan->gejala->firstWhere('id', $g->id)?->pivot->cf ?? '');
                            @endphp
                            <tr>
                                <td class="border text-center">
                                    <input type="checkbox" name="gejala_ids[]" value="{{ $g->id }}"
                                        class="gejala-checkbox" data-id="{{ $g->id }}"
                                        {{ $selected ? 'checked' : '' }}>
                                </td>
                                <td class="border px-2 py-1">{{ $g->gejala ?? '-' }}</td>
                                <td class="border text-center">
                                    <select name="cf[{{ $g->id }}]" id="cf-{{ $g->id }}"
                                        class="cf-select border rounded px-2 py-1 text-sm"
                                        {{ $selected ? '' : 'disabled' }}>
                                        <option value="">-- Pilih CF --</option>
                                        @foreach (range(0.1, 1.0, 0.1) as $val)
                                        <option value="{{ number_format($val, 1) }}"
                                            {{ $cf_value == number_format($val, 1) ? 'selected' : '' }}>
                                            {{ number_format($val, 1) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @error('gejala_ids')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    @error('cf')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        {{ $page_meta['button'] }}
                    </button>
                </div>
            </form>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Toggle aktif/nonaktif dropdown CF
            document.querySelectorAll('.gejala-checkbox').forEach(checkbox => {
                const id = checkbox.dataset.id;
                const select = document.getElementById(`cf-${id}`);

                // Set default state
                select.disabled = !checkbox.checked;

                // Saat checkbox berubah
                checkbox.addEventListener('change', () => {
                    select.disabled = !checkbox.checked;
                    if (!checkbox.checked) {
                        select.value = '';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>