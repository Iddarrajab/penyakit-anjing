<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center pt-20 px-4">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">

            <div class="flex justify-center">
                <img class="w-auto h-7 sm:h-8" src="https://merakiui.com/images/logo.svg" alt="Logo" />
            </div>

            <h2 class="mt-4 text-center text-lg font-semibold text-gray-700 dark:text-white">
                Verifikasi OTP
            </h2>

            {{-- pesan error --}}
            @if(session('error'))
            <p class="text-sm text-red-600 mt-4 text-center">{{ session('error') }}</p>
            @endif

            {{-- pesan sukses --}}
            @if(session('success'))
            <p class="text-sm text-green-600 mt-4 text-center">{{ session('success') }}</p>
            @endif

            <form action="/verify-otp" method="POST" class="mt-6">
                @csrf

                {{-- OTP --}}
                <div>
                    <label for="otp" class="block text-sm text-gray-800 dark:text-gray-200 text-center">
                        Masukkan Kode OTP
                    </label>

                    <input type="text" name="otp" id="otp" required maxlength="6"
                        class="text-center tracking-widest text-lg block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg
                               dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600
                               focus:border-blue-400 dark:focus:border-blue-300
                               focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="******" />

                    @error('otp')
                    <p class="text-sm text-red-600 mt-1 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-medium tracking-wide text-white
                        transition-colors duration-300 transform bg-gray-800 rounded-lg
                        hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Verifikasi
                    </button>
                </div>
            </form>

            <div class="mt-6 text-xs text-center text-gray-400">
                Tidak menerima OTP?
                <a href="#" class="text-gray-700 hover:underline">Kirim ulang</a>
            </div>

        </div>
    </div>
</body>

</html>