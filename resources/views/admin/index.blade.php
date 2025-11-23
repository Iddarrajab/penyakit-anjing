<x-app-layout tittle="admin">

    <x-slot name="heading">
        admin
    </x-slot>

    <x-slot name="body">
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex sm:justify-end">
            <x-button as="a" href="{{ route('admin.create') }}">
                Add admin
            </x-button>
        </div>


        <div class="mt-4 flow-root">
            <table class="w-full border border-gray-400 border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border border-gray-400">name</th>
                        <th class="px-3 py-2 border border-gray-400">email</th>
                        <th class="px-3 py-2 border border-gray-400">tangggal</th>
                        <th class="px-3 py-2 border border-gray-400">view</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $admin)
                    <tr>
                        <td class="px-3 py-2 border border-gray-400">{{$admin->name}}</td>
                        <td class="px-3 py-2 border border-gray-400">{{$admin->email}}</td>
                        <td class="px-3 py-2 border border-gray-400">{{$admin->created_at}}</td>
                        <td class="px-3 py-2 border border-gray-400">
                            <div class="flex justify-end gap-x-2">
                                <a href="{{route ('admin.show', $admin)}}" class="hover:underline">
                                    view
                                </a>
                                <a href="{{ route('admin.edit', $admin) }}" class="btn btn-warning">
                                    Edit
                                </a>
                        </td>
        </div>
        @endforeach


        </tbody>
        </table>
        </div>
    </x-slot>
</x-app-layout>