<x-app-layout tittle="penyakit">

    <x-slot name="heading">
        {{$penyakit->penyakit}}
    </x-slot>

    <x-slot name="body">
        <div class="">{{$penyakit->penyakit}}</div>
        <div>Registrasi at {{ $penyakit->created_at->diffForHumans()}}</div>
        <form action="{{route ('penyakit.destroy', $penyakit)}}" method="POST" class="mt-6">
            @method('DELETE')
            @csrf
            <x-button>
                delete
            </x-button>
        </form>

    </x-slot>
</x-app-layout>