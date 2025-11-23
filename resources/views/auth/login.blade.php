<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center pt-20 px-4">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex justify-center">
                <img class="w-auto h-7 sm:h-8" src="https://merakiui.com/images/logo.svg" alt="Logo" />
            </div>

            @if(session('error'))
            <p class="text-sm text-red-600 mt-4 text-center">{{ session('error') }}</p>
            @endif

            <form action="{{ route('login') }}" method="POST" class="mt-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm text-gray-800 dark:text-gray-200">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800
                               dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300
                               focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm text-gray-800 dark:text-gray-200">Password</label>
                        <a href="#" class="text-xs text-gray-600 dark:text-gray-400 hover:underline">Forget Password?</a>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800
                               dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300
                               focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
                    @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <x-button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-medium tracking-wide text-white capitalize
                        transition-colors duration-300 transform bg-gray-800 rounded-lg
                        hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Sign In
                    </x-button>
                </div>
            </form>

            <div class="mt-8 text-xs font-light text-center text-gray-400">
                Don't have an account?
                <a href="{{route('user.create')}}" class="font-medium text-gray-700 dark:text-gray-200 hover:underline">Create One</a>
            </div>
        </div>
    </div>
</body>

</html>