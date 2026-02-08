@extends('layouts.app')

@section('title', 'Beranda - Donasi Online')

@section('content')
<!-- Hero Section -->
<section style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Platform Donasi Online Terpercaya</h1>
            <p class="text-xl mb-8" style="color: #b3e0f1;">Berikan kontribusi Anda untuk kebaikan bersama. Mudah, aman, dan transparan.</p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ route('donations.create') }}" style="background-color: white; color: #0b5b80;" class="hover:bg-blue-50 font-bold py-3 px-8 rounded-lg transition">
                    Mulai Berdonasi
                </a>
                <a href="{{ route('donations.listSuccess') }}" style="background-color: #0e6e99;" class="text-white hover:opacity-90 font-bold py-3 px-8 rounded-lg transition border-2 border-white">
                    Lihat Donasi
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Mengapa Memilih Kami?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Fitur 1 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div style="background-color: #d4e9f5;" class="w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                    <i style="color: #0b5b80;" class="fas fa-qrcode text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pembayaran QRIS</h3>
                <p class="text-gray-600">Scan kode QR dengan mudah menggunakan aplikasi e-wallet atau mobile banking Anda.</p>
            </div>

            <!-- Fitur 2 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-university text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Transfer Bank</h3>
                <p class="text-gray-600">Transfer langsung ke rekening kami dari bank pilihan Anda dengan mudah.</p>
            </div>

            <!-- Fitur 3 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Aman & Transparan</h3>
                <p class="text-gray-600">Setiap transaksi dijamin aman dengan enkripsi tingkat bank dan laporan yang transparan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Campaign Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Campaign Yang Membutuhkan Dukungan Anda</h2>
            <p class="text-gray-600 text-lg">Lihat campaign-campaign penting yang sedang berjalan dan ambil bagian dalam perubahan positif</p>
        </div>

        @php
            $campaigns = \App\Models\Campaign::where('status', 'active')->orderBy('created_at', 'desc')->take(3)->get();
        @endphp

        @if($campaigns->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($campaigns as $campaign)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="relative h-48 bg-gradient-to-r from-teal-600 to-teal-700 overflow-hidden">
                            @if($campaign->image)
                                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-white text-5xl opacity-50"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $campaign->description }}</p>

                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-semibold text-teal-700">
                                        Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ round($campaign->getProgressPercentage()) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div 
                                        class="bg-teal-600 h-2 rounded-full transition-all duration-300"
                                        style="width: {{ $campaign->getProgressPercentage() }}%"
                                    ></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Target: Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex justify-between items-center text-sm text-gray-600 mb-4 pb-4 border-b">
                                <span><i class="fas fa-users text-teal-600 mr-1"></i> {{ $campaign->getDonorCount() }} donatur</span>
                                @if($campaign->deadline)
                                    <span><i class="fas fa-clock text-teal-600 mr-1"></i> {{ $campaign->deadline->diffForHumans() }}</span>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-2 rounded text-center text-sm font-semibold transition">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('donations.create', ['campaign_id' => $campaign->id]) }}" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 rounded text-center text-sm font-semibold transition">
                                    Donasi
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('campaigns.index') }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-lg transition">
                    <i class="fas fa-arrow-right mr-2"></i>Lihat Semua Campaign
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg">Belum ada campaign saat ini</p>
            </div>
        @endif
    </div>
</section>

<!-- Tentang Kami / Profil Organisasi -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-800 mb-4">
                    <span style="color: #0b5b80;">Inspirasi Muda,</span><br>
                    <span style="color: #0b5b80;">Cita Untuk Indonesia</span>
                </h2>
                <p style="color: #0e6e99;" class="text-2xl font-semibold mb-4">Ayo Bersama Untuk Indonesia</p>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Muda Cita Indonesia hadir untuk menciptakan perubahan nyata melalui kolaborasi dan aksi bersama. Mari wujudkan masa depan yang lebih baik untuk generasi muda Indonesia.</p>
            </div>

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                <!-- Kolom 1: Visi & Misi -->
                <div style="background: linear-gradient(135deg, #d4e9f5, #a8d4e8);" class="rounded-lg p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">🎯 Gerakan Anak Muda yang Berdaya</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Muda Cita Indonesia Foundation adalah organisasi sosial yang digerakkan oleh semangat <strong>kolaborasi, integritas, dan pengabdian</strong>.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Kami bekerja bersama relawan, komunitas lokal, dan mitra strategis untuk menjawab persoalan pendidikan, sosial, dan lingkungan secara berkelanjutan.
                    </p>
                </div>

                <!-- Kolom 2: Filosofi -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">💭 Filosofi Kami</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="text-3xl">❌</div>
                            <div>
                                <p class="font-semibold text-gray-800">Kami TIDAK datang membawa solusi instan</p>
                                <p class="text-sm text-gray-600">Percaya pada proses berkelanjutan</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="text-3xl">✅</div>
                            <div>
                                <p class="font-semibold text-gray-800">Kami DATANG untuk mendengar, belajar, dan bertumbuh</p>
                                <p class="text-sm text-gray-600">Bersama masyarakat yang kami layani</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fokus Area -->
            <div style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white rounded-lg p-8 shadow-xl mb-8">
                <h3 class="text-2xl font-bold mb-6 text-center">Fokus Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-4xl mb-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4 class="font-bold mb-2">Pendidikan</h4>
                        <p style="color: #b3e0f1;">Program pemberdayaan pendidikan untuk generasi muda</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4 class="font-bold mb-2">Sosial</h4>
                        <p style="color: #b3e0f1;">Pembangunan komunitas yang inklusif dan berkelanjutan</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="font-bold mb-2">Lingkungan</h4>
                        <p style="color: #b3e0f1;">Aksi nyata untuk menjaga kelestarian lingkungan</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Bergabunglah Dengan Gerakan Kami</h3>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="{{ route('donations.create') }}" style="background-color: #0b5b80;" class="hover:opacity-90 text-white font-bold py-3 px-8 rounded-lg transition">
                        <i class="fas fa-heart"></i> Donasi Sekarang
                    </a>
                    <a href="{{ route('donations.listSuccess') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        <i class="fas fa-users"></i> Lihat Donasi yang Terkumpul
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Campaign Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-4">Campaign Terbaru</h2>
        <p class="text-center text-gray-600 mb-12">Dukung berbagai campaign penting untuk membantu sesama</p>
        
        <div class="flex justify-center mb-8">
            <a href="{{ route('campaigns.index') }}" style="background-color: #0b5b80;" class="hover:opacity-90 text-white font-bold py-3 px-8 rounded-lg transition">
                <i class="fas fa-list"></i> Lihat Semua Campaign
            </a>
        </div>
    </div>
</section>
</section>

<!-- Cara Kerja Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Cara Berdonasi</h2>
        
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row gap-8 mb-8">
                <!-- Step 1 -->
                <div class="flex-1 text-center">
                    <div style="background-color: #0b5b80;" class="w-16 h-16 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="font-bold text-lg mb-2">Isi Form Donasi</h3>
                    <p class="text-gray-600">Masukkan data diri dan jumlah donasi Anda</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center text-4xl text-gray-300">→</div>

                <!-- Step 2 -->
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="font-bold text-lg mb-2">Pilih Metode Pembayaran</h3>
                    <p class="text-gray-600">Pilih QRIS atau transfer bank</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center text-4xl text-gray-300">→</div>

                <!-- Step 3 -->
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="font-bold text-lg mb-2">Lakukan Pembayaran</h3>
                    <p class="text-gray-600">Selesaikan pembayaran sesuai pilihan Anda</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Step 4 -->
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-yellow-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                    <h3 class="font-bold text-lg mb-2">Konfirmasi</h3>
                    <p class="text-gray-600">Tunggu konfirmasi pembayaran</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center text-4xl text-gray-300">→</div>

                <!-- Step 5 -->
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">✓</div>
                    <h3 class="font-bold text-lg mb-2">Selesai!</h3>
                    <p class="text-gray-600">Donasi Anda telah diterima</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center text-4xl text-gray-300"></div>

                <!-- Step 6 -->
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">❤️</div>
                    <h3 class="font-bold text-lg mb-2">Terima Kasih!</h3>
                    <p class="text-gray-600">Kontribusi Anda membuat perbedaan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(to right, #0b5b80, #064a66);" class="text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Siap untuk Membantu?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto" style="color: #b3e0f1;">Setiap donasi Anda memiliki dampak yang berarti. Mari bersama-sama membuat perbedaan untuk yang membutuhkan.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('donations.create') }}" style="background-color: white; color: #0b5b80;" class="hover:opacity-90 font-bold py-3 px-8 rounded-lg transition inline-block">
                Donasi Sekarang
            </a>
            @guest
            <a href="{{ route('auth.login') }}" style="background-color: #0e6e99;" class="text-white hover:opacity-90 font-bold py-3 px-8 rounded-lg transition inline-block border-2 border-white">
                Login Admin
            </a>
            @else
            <a href="{{ route('admin.dashboard') }}" style="background-color: #0e6e99;" class="text-white hover:opacity-90 font-bold py-3 px-8 rounded-lg transition inline-block border-2 border-white">
                Dashboard Admin
            </a>
            @endguest
        </div>
    </div>
</section>
@endsection
