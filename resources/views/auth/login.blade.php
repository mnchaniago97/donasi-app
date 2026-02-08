<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Donasi Online</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div style="background-color: #d4e9f5;" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i style="color: #0b5b80;" class="fas fa-lock text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-600 text-sm mt-2">Platform Donasi Online</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('auth.login') }}" method="POST">
                @csrf

                <div class="mb-6">
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

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-transparent focus:border-transparent @error('password') border-red-500 @enderror"
                        style="--tw-ring-color: #0b5b80;"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        style="accent-color: #0b5b80;" class="w-4 h-4 border-gray-300 rounded focus:ring-2"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    style="background-color: #0b5b80;" class="w-full hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                >
                    Login
                </button>
            </form>

            <!-- Divider -->
            <div class="relative mt-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Back Link -->
            <div class="mt-6 text-center">
                <a href="/" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    ← Kembali ke Beranda
                </a>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('auth.register') }}" class="text-sm font-medium" style="color: #0b5b80;">
                    Buat akun admin baru
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

