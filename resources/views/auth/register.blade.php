<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Donasi Online</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div style="background-color: #d4e9f5;" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i style="color: #0b5b80;" class="fas fa-user-plus text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Buat Akun Admin</h1>
                <p class="text-gray-600 text-sm mt-2">Platform Donasi Online</p>
            </div>

            <!-- Register Form -->
            <form action="{{ route('auth.register') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-transparent focus:border-transparent @error('name') border-red-500 @enderror"
                        style="--tw-ring-color: #0b5b80;"
                        placeholder="Nama lengkap"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-transparent focus:border-transparent @error('email') border-red-500 @enderror"
                        style="--tw-ring-color: #0b5b80;"
                        placeholder="admin@donasi.app"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-transparent focus:border-transparent @error('password') border-red-500 @enderror"
                        style="--tw-ring-color: #0b5b80;"
                        placeholder="Minimal 6 karakter"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-transparent focus:border-transparent"
                        style="--tw-ring-color: #0b5b80;"
                        placeholder="Ulangi password"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button
                    type="submit"
                    style="background-color: #0b5b80;" class="w-full hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                >
                    Daftar
                </button>
            </form>

            <!-- Divider -->
            <div class="relative mt-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">sudah punya akun?</span>
                </div>
            </div>

            <!-- Back Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('auth.login') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Login di sini
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

