<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App') - Donasi Online</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 font-bold text-xl">
                    <i class="fas fa-heart text-2xl"></i>
                    Donasi Online
                </a>

                <!-- Menu -->
                <div class="hidden md:flex gap-6">
                    <a href="/" style="color: inherit;" class="hover:opacity-70 transition">Beranda</a>
                    <a href="{{ route('donations.create') }}" style="color: inherit;" class="hover:opacity-70 transition">Donasi</a>
                    <a href="{{ route('donations.listSuccess') }}" style="color: inherit;" class="hover:opacity-70 transition">Daftar Donasi</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" style="color: inherit;" class="hover:opacity-70 transition">Admin</a>
                    @else
                        <a href="{{ route('auth.login') }}" style="color: inherit;" class="hover:opacity-70 transition">Login</a>
                    @endauth
                </div>

                <!-- Auth Dropdown / Mobile Menu Button -->
                <div class="flex items-center gap-4">
                    @auth
                    <div class="hidden md:flex items-center gap-4">
                        <span style="color: #b3e0f1;" class="text-sm\">👤 {{ Auth::user()->name }}</span>
                        <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" style="color: inherit;" class="hover:opacity-70 transition text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden" id="menu-toggle">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden pb-4 space-y-2">
                <a href="/" style="color: inherit;" class="block hover:opacity-70 transition py-2">Beranda</a>
                <a href="{{ route('donations.create') }}" style="color: inherit;" class="block hover:opacity-70 transition py-2">Donasi</a>
                <a href="{{ route('donations.listSuccess') }}" style="color: inherit;" class="block hover:opacity-70 transition py-2">Daftar Donasi</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" style="color: inherit;" class="block hover:opacity-70 transition py-2">Admin</a>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block hover:text-blue-200 transition py-2 w-full text-left">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}" class="block hover:text-blue-200 transition py-2">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-12">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="font-bold text-white mb-4">Tentang Kami</h4>
                    <p class="text-sm">Platform donasi online yang memudahkan Anda untuk berkontribusi kepada berbagai kegiatan sosial.</p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Menu</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="/" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('donations.create') }}" class="hover:text-white">Berdonasi</a></li>
                        <li><a href="{{ route('donations.listSuccess') }}" class="hover:text-white">Daftar Donasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Metode Pembayaran</h4>
                    <ul class="text-sm space-y-2">
                        <li>✓ QRIS</li>
                        <li>✓ Transfer Bank</li>
                        <li>✓ E-Wallet</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Hubungi Kami</h4>
                    <ul class="text-sm space-y-2">
                        <li>Email: info@donasi.app</li>
                        <li>Telepon: +62 812 3456 7890</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Donasi Online. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
