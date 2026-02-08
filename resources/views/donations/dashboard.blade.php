<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Donasi Online</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 h-screen overflow-hidden">
    <!-- Navigation -->
    <nav style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <button id="sidebar-open" type="button" class="lg:hidden p-2 rounded-md hover:bg-white/10 transition" aria-label="Buka menu">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="/" class="flex items-center gap-2 font-bold text-xl">
                        <i class="fas fa-heart text-2xl"></i>
                        Donasi Online
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span style="color: #b3e0f1;" class="text-sm text-blue-100">👤 {{ Auth::user()->name ?? 'Admin' }}</span>
                    <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="flex h-[calc(100vh-4rem)] bg-gray-50">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-x-0 top-16 bottom-0 bg-black/40 z-40 hidden lg:hidden"></div>
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-lg fixed top-16 left-0 z-40 transform -translate-x-full transition-transform duration-200 h-[calc(100vh-4rem)] lg:static lg:h-auto lg:translate-x-0">
            @include('partials.sidebar')
        </aside>
        

        <!-- Main Content -->
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8 lg:py-12 lg:ml-0 overflow-y-auto h-[calc(100vh-4rem)]">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-gray-600">Kelola dan monitor donasi Anda</p>
            </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div style="background: linear-gradient(to bottom right, #0b5b80, #0e6e99);" class="rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p style="color: #b3e0f1;" class="text-blue-100 text-sm mb-1">Total Donasi</p>
                    <p class="text-3xl font-bold">{{ $totalDonations }}</p>
                </div>
                <i class="fas fa-heart text-4xl text-blue-300"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Terkumpul</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-wallet text-4xl text-green-300"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Rata-rata</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalDonations > 0 ? $totalAmount / $totalDonations : 0, 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-chart-bar text-4xl text-purple-300"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm mb-1">Bulan Ini</p>
                    <p class="text-2xl font-bold">Rp {{ number_format(\App\Models\Donation::completed()->whereYear('payment_completed_at', now()->year)->whereMonth('payment_completed_at', now()->month)->sum('amount'), 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-calendar-alt text-4xl text-orange-300"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Donasi Terbaru -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Donasi Terbaru</h2>
                
                @if($recentDonations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Donatur</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Jumlah</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Metode</th>
                                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDonations as $donation)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-2">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $donation->donor_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $donation->donor_email }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 font-bold text-green-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-2">
                                        @if($donation->payment_method === 'qris')
                                            <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-medium">
                                                <i class="fas fa-qrcode"></i>
                                                QRIS
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                                                <i class="fas fa-building"></i>
                                                Bank
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 text-sm text-gray-600">{{ $donation->payment_completed_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada donasi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.bank-accounts.index') }}" style="background-color: #0b5b80;" class="block hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                        Kelola Rekening Bank
                    </a>
                    <a href="{{ route('donations.listSuccess') }}" class="block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                        Lihat Semua Donasi
                    </a>
                    <a href="{{ route('donations.create') }}" class="block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                        Tambah Donasi Manual
                    </a>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #d4e9f5, #f0f9fc); border-color: #a8d4e8;" class="rounded-lg p-6 border">
                <h3 class="font-bold text-gray-800 mb-3">💡 Tips</h3>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li>✓ Selalu update data rekening bank</li>
                    <li>✓ Monitor donasi secara berkala</li>
                    <li>✓ Aktifkan notifikasi webhook</li>
                    <li>✓ Kirim terima kasih kepada donatur</li>
                </ul>
            </div>
        </main>
    </div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('sidebar-open');
    const closeBtn = document.getElementById('sidebar-close');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
</script>

</body>
</html>








