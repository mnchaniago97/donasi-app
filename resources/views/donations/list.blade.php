@extends('layouts.app')

@section('title', 'Daftar Donasi')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Donasi yang Diterima</h1>
        <p class="text-gray-600">Terima kasih atas dukungan Anda untuk kami</p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div style="background-color: #d4e9f5;" class="rounded-lg p-3 mr-4">
                    <i style="color: #0b5b80;" class="fas fa-heartbeat text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Donasi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $donations->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-wallet text-2xl text-green-600"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Jumlah Terkumpul</p>
                    <p class="text-2xl font-bold text-green-600" id="total-amount">Rp 0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-poll text-2xl text-purple-600"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Rata-rata Donasi</p>
                    <p class="text-2xl font-bold text-purple-600" id="average-amount">Rp 0</p>
                </div>
            </div>
        </div>
    </div>

    @if($donations->count() > 0)
        <!-- Daftar Donasi -->
        <div class="space-y-4">
            @foreach($donations as $donation)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-gray-800">{{ $donation->donor_name }}</h3>
                            @if($donation->campaign_title)
                                <span style="background-color: #d4e9f5; color: #0b5b80;" class="text-xs px-2 py-1 rounded">{{ $donation->campaign_title }}</span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $donation->donor_email }}</p>
                        
                        @if($donation->message)
                        <div class="bg-gray-50 rounded-lg p-3 mb-3 italic text-gray-600 text-sm">
                            "{{ $donation->message }}"
                        </div>
                        @endif

                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <span>{{ $donation->payment_completed_at->format('d M Y H:i') }}</span>
                            <span class="flex items-center gap-1">
                                @if($donation->payment_method === 'qris')
                                    <i class="fas fa-qrcode"></i>
                                    QRIS
                                @else
                                    <i class="fas fa-building"></i>
                                    Transfer Bank
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                        <span class="inline-block mt-2 bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">✓ Berhasil</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $donations->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-5xl text-gray-400 mb-4">
                <i class="fas fa-heart"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Donasi</h3>
            <p class="text-gray-600 mb-6">Jadilah yang pertama memberikan donasi</p>
            <a href="{{ route('donations.create') }}" style="background-color: #0b5b80;" class="hover:opacity-90 text-white font-bold py-2 px-6 rounded-lg">
                Buat Donasi
            </a>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const donations = @json($donations->items());
        let total = 0;
        
        donations.forEach(donation => {
            total += donation.amount;
        });

        const average = donations.length > 0 ? total / donations.length : 0;
        
        document.getElementById('total-amount').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('average-amount').innerText = 'Rp ' + Math.round(average).toLocaleString('id-ID');
    });
</script>
@endsection
