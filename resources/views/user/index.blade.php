<x-app-layout title="User">

    <x-slot name="heading">
        User
    </x-slot>

    <x-slot name="body">
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex sm:justify-end">
            <x-button as="a" href="{{ route('user.create') }}">
                Add User
            </x-button>
        </div>

        <div class="mt-4 flow-root">
            <table class="w-full border border-gray-400 border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border border-gray-400">Name</th>
                        <th class="px-3 py-2 border border-gray-400">Email</th>
                        <th class="px-3 py-2 border border-gray-400">Tanggal</th>
                        <th class="px-3 py-2 border border-gray-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-3 py-2 border border-gray-400">{{ $user->name }}</td>
                        <td class="px-3 py-2 border border-gray-400">{{ $user->email }}</td>
                        <td class="px-3 py-2 border border-gray-400">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-3 py-2 border border-gray-400">
                            <div class="flex justify-end gap-x-2">
                                <form action="{{ route('user.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                                <a href="{{ route('user.edit', $user) }}" class="text-yellow-600 hover:underline">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>