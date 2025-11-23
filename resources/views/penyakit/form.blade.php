<x-app-layout title="{{$page_meta['title']}}">
    <x-slot name="heading">
        {{ $page_meta['title']}}
    </x-slot>

    <x-slot name="body">
        <h1 class="text-xl font-semibold mb-4">update data</h1>

        @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>

        @endif

        <form method="POST" action="{{$page_meta['url']}}">
            @method($page_meta['method'])
            @csrf




            {{-- code --}}
            <label for="code" class="block font-medium">code:</label>
            <input type="text" value="{{ old('code', $penyakit->code)}}" name="code" id="code" class="border rounded px-2 py-1 w-full mb-3">

            @error('code')
            <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
            @enderror
            {{-- penyakit --}}
            <label for="penyakit" class="block font-medium">penyakit:</label>
            <input type="text" value="{{ old('penyakit', $penyakit->penyakit)}}" name="penyakit" id="penyakit" class="border rounded px-2 py-1 w-full mb-3 ">

            @error('penyakit')
            <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
            @enderror
            {{-- solusi --}}
            <label for="solusi" class="block font-medium">solusi:</label>
            <input type="text" value="{{ old('solusi', $penyakit->solusi)}}" name="solusi" id="solusi" class="border rounded px-2 py-1 w-full mb-3">

            @error('solusi')
            <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
            @enderror

            {{-- obat --}}
            <label for="obat" class="block font-medium mt-4">obat:</label>
            <input type="text" value="{{ old('obat', $penyakit->obat)}}" name="obat" id="obat" class="border rounded px-2 py-1 w-full mb-3">
            @error('obat')
            <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
            @enderror

            <x-button class="mt-6">
                {{$page_meta['button']}}
            </x-button>
        </form>
    </x-slot>
</x-app-layout>