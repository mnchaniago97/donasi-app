@extends('layouts.app')

@section('title', 'Detail Donasi')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Status Badge -->
            <div class="text-center mb-8">
                @if($donation->isSuccess())
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                        <i class="fas fa-check text-4xl text-green-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-green-600 mb-2">Donasi Berhasil!</h1>
                    <p class="text-gray-600">Terima kasih atas donasi Anda</p>
                @elseif($donation->isPending())
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full mb-4">
                        <i class="fas fa-hourglass-half text-4xl text-yellow-600 animate-pulse"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-yellow-600 mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600">Kabar baik segera tiba</p>
                @else
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-4">
                        <i class="fas fa-times text-4xl text-red-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-red-600 mb-2">Pembayaran Gagal</h1>
                    <p class="text-gray-600">Silakan coba lagi</p>
                @endif
            </div>

            <!-- Detail Donasi -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 space-y-4">
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Nama Donatur:</span>
                    <span class="font-medium text-gray-800">{{ $donation->donor_name }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-medium text-gray-800">{{ $donation->donor_email }}</span>
                </div>
                @if($donation->donor_phone)
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Telepon:</span>
                    <span class="font-medium text-gray-800">{{ $donation->donor_phone }}</span>
                </div>
                @endif
                @if($donation->campaign_title)
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Kampanye:</span>
                    <span class="font-medium text-gray-800">{{ $donation->campaign_title }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Metode Pembayaran:</span>
                    <span class="font-medium text-gray-800">
                        @if($donation->payment_method === 'qris')
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded text-sm">QRIS</span>
                        @else
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm">Transfer Bank</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-lg font-semibold text-gray-600">Jumlah Donasi:</span>
                    <span style="color: #0b5b80;" class="text-2xl font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Pesan Donatur -->
            @if($donation->message)
            <div style="background-color: #f0f9fc; border-left-color: #0b5b80;" class="border-l-4 rounded-lg p-6 mb-8">
                <h3 class="font-bold text-gray-800 mb-2">Pesan Personal:</h3>
                <p class="text-gray-700">{{ $donation->message }}</p>
            </div>
            @endif

            <!-- Additional Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 space-y-3 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>ID Donasi:</span>
                    <span class="font-mono text-gray-800">{{ $donation->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tanggal Donasi:</span>
                    <span class="text-gray-800">{{ $donation->created_at->format('d M Y H:i') }}</span>
                </div>
                @if($donation->payment_completed_at)
                <div class="flex justify-between">
                    <span>Tanggal Pembayaran:</span>
                    <span class="text-gray-800">{{ $donation->payment_completed_at->format('d M Y H:i') }}</span>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex gap-4 justify-center">
                @if($donation->isPending())
                    <a href="{{ route('donations.payment', $donation) }}" style="background-color: #0b5b80;" class="hover:opacity-90 text-white font-bold py-2 px-6 rounded-lg transition">
                        Kembali ke Pembayaran
                    </a>
                @endif
                <a href="{{ route('donations.create') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Donasi Lagi
                </a>
                <a href="{{ route('donations.listSuccess') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Lihat Donasi Lain
                </a>
            </div>

            <!-- Footer Message -->
            <div class="mt-8 text-center text-gray-500 text-sm">
                <p>Terima kasih telah menjadi bagian dari perubahan positif</p>
            </div>
        </div>
    </div>
</div>
@endsection
