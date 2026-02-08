            <div class="lg:hidden flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="font-bold text-gray-800">Menu Admin</span>
                <button id="sidebar-close" type="button" class="p-2 rounded-md hover:bg-gray-100 transition" aria-label="Tutup menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <h3 class="hidden lg:block text-lg font-bold text-gray-800 mb-6">Menu Admin</h3>
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
