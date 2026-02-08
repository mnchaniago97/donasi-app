<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Rekening Bank</title>
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
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Rekening Bank</h1>
                    
                </div>
                <a href="{{ route('admin.bank-accounts.create') }}" style="background-color: #0b5b80;" class="hover:opacity-90 text-white font-bold py-2 px-6 rounded-lg">
                    + Tambah Rekening
                </a>
            </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($bankAccounts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($bankAccounts as $account)
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 {{ $account->is_active ? 'border-green-500' : 'border-gray-300' }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $account->bank_name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $account->account_holder_name }}</p>
                    </div>
                    <span class="inline-block {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $account->is_active ? '✓ Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Nomor Rekening</p>
                    <p class="font-mono text-lg text-gray-800">{{ $account->account_number }}</p>
                </div>

                {{-- QRIS Merchant --}}
                @if($account->qris_merchant_file)
                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-3 font-semibold"><i class="fas fa-qrcode" style="color: #0b5b80;"></i> QRIS Merchant:</p>
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $account->qris_merchant_file) }}" alt="QRIS Merchant" class="w-40 h-40 mx-auto rounded-lg">
                    </div>
                </div>
                @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 text-center">
                    <p class="text-sm text-gray-600"><i class="fas fa-exclamation-circle" style="color: #0b5b80;\"></i> Belum ada QRIS Merchant</p>
                </div>
                @endif

                @if($account->description)
                <div class="mb-4">
                    <p class="text-sm text-gray-600">{{ $account->description }}</p>
                </div>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('admin.bank-accounts.edit', $account) }}" style="background-color: #0e6e99;" class="flex-1 hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-5xl text-gray-400 mb-4">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Rekening Bank</h3>
            <p class="text-gray-600 mb-6">Tambahkan rekening bank untuk menerima donasi</p>
            <a href="{{ route('admin.bank-accounts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                Tambah Rekening
            </a>
        </div>
    @endif
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







