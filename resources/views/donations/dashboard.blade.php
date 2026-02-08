<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Donasi Online</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-2 font-bold text-xl">
                    <i class="fas fa-heart text-2xl"></i>
                    Donasi Online
                </a>
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
    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Menu Admin</h3>
                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" style="background-color: #0b5b80;" class="text-white font-medium transition flex items-center gap-3 px-4 py-3 rounded-lg">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>

                    <!-- Kelola Rekening Bank -->
                    <a href="{{ route('admin.bank-accounts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 font-medium transition">
                        <i class="fas fa-university"></i>
                        Kelola Rekening
                    </a>

                    <!-- Daftar Donasi -->
                    <a href="{{ route('donations.listSuccess') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 font-medium transition">
                        <i class="fas fa-list-alt"></i>
                        Daftar Donasi
                    </a>

                    <!-- Formulir Donasi -->
                    <a href="{{ route('donations.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 font-medium transition">
                        <i class="fas fa-heart"></i>
                        Formulir Donasi
                    </a>

                    <!-- Divider -->
                    <div class="my-6 border-t border-gray-200"></div>

                    <!-- Logout -->
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 text-red-600 font-medium transition">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-gray-600">Kelola dan monitor donasi Anda</p>
            </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
    // Toggle mobile menu
    const menuToggle = document.getElementById('menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
        });
    }
</script>

</body>
</html>
