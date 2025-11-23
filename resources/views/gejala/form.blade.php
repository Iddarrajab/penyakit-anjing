<x-app-layout title="From gejala">
    <x-slot name="heading">
        {{ $page_meta['title']}}
    </x-slot>

    <x-slot name="body">
        <div class="w-full px-6 py-6 mx-auto">
            <div class="w-full px-6 py-6 mx-auto overflow-x-auto">
                <h1 class="text-xl font-semibold mb-4">update data</h1>

                @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>

                @endif

                <form method="POST" action="{{$page_meta['url']}}">
                    @method($page_meta['method'])
                    @csrf




                    {{-- gejala --}}
                    <label for="gejala" class="block font-medium">gejala:</label>
                    <input type="text" value="{{ old('gejala', $gejala->gejala)}}" name="gejala" id="gejala" class="border rounded px-2 py-1 w-full mb-3">

                    @error('gejala')
                    <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
                    @enderror

                    {{-- code --}}
                    <label for="code" class="block font-medium mt-4">code:</label>
                    <input type="text" value="{{ old('code', $gejala->code)}}" name="code" id="code" class="border rounded px-2 py-1 w-full mb-3 ">
                    @error('code')
                    <p class="text-sm text-red-600 mt-1 mb-3">{{ $message }}</p>
                    @enderror

                    <x-button class="mt-6">
                        {{$page_meta['button']}}
                    </x-button>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>