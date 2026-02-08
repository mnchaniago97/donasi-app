@extends('layouts.app')

@section('title', 'Pembayaran Donasi')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Detail Donasi -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Donasi</h2>

                    <div class="space-y-4 border-b pb-6 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium text-gray-800">{{ $donation->donor_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium text-gray-800">{{ $donation->donor_email }}</span>
                        </div>
                        @if($donation->donor_phone)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="font-medium text-gray-800">{{ $donation->donor_phone }}</span>
                        </div>
                        @endif
                        @if($donation->campaign_title)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kampanye:</span>
                            <span class="font-medium text-gray-800">{{ $donation->campaign_title }}</span>
                        </div>
                        @endif
                    </div>

                    <div style="background-color: #f0f9fc;" class="py-6 rounded-lg mb-6">
                        <p class="text-gray-600 text-sm mb-2">Jumlah Donasi</p>
                        <p style="color: #0b5b80;" class="text-4xl font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                        
                        @if($donation->payment_method === 'qris')
                            <div style="background: linear-gradient(135deg, #f0f9fc, #d4e9f5);" class="rounded-lg p-6 lg:p-8">
                                <div class="text-center mb-8">
                                    <div class="mb-4 text-5xl lg:text-6xl" style="color: #0b5b80;">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <h4 class="text-xl lg:text-2xl font-bold text-gray-800 mb-2">Pembayaran QRIS</h4>
                                    <p class="text-gray-600 mb-6">Scan QR Code dengan aplikasi e-wallet atau mobile banking Anda</p>
                                </div>

                                {{-- Nominal Pembayaran --}}
                                <div style="background: white; border-color: #0b5b80;" class="rounded-lg p-6 lg:p-8 text-center border-2 mb-6">
                                    <p class="text-gray-600 text-sm mb-3 font-medium">Nominal yang Harus Dibayar</p>
                                    <p style="color: #0b5b80;" class="text-4xl lg:text-5xl font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                    <p class="text-gray-500 text-xs mt-3">Nominal ini sudah included dalam QR Code di bawah</p>
                                </div>

                                {{-- QRIS Merchant Cards --}}
                                <div class="space-y-5">
                                    <h5 class="text-lg font-bold text-gray-800 text-center">Pilih Rekening & Scan</h5>
                                    @foreach($bankAccounts as $account)
                                        @if($account->qris_merchant_file)
                                        <div class="border-2 border-gray-300 rounded-lg p-5 lg:p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
                                            <p class="font-bold text-gray-800 mb-2 text-lg">{{ $account->bank_name }}</p>
                                            <p class="text-gray-600 mb-4 text-sm">{{ $account->account_holder_name }}</p>
                                            <div class="flex justify-center mb-3">
                                                <img src="{{ asset('storage/' . $account->qris_merchant_file) }}" alt="QRIS Merchant" class="w-48 h-48 lg:w-56 lg:h-56 rounded-lg shadow-md">
                                            </div>
                                            <p class="text-xs text-gray-600 text-center">Tap & scan QR Code di atas</p>
                                        </div>
                                        @endif
                                    @endforeach
                                    @if(!$bankAccounts->where('qris_merchant_file', '!=', null)->count())
                                    <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-5 lg:p-6">
                                        <p class="text-sm lg:text-base text-yellow-800"><i class="fas fa-exclamation-circle"></i> QRIS Merchant belum tersedia. Hubungi admin.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="space-y-5">
                                {{-- Jumlah yang harus dibayar --}}
                                <div style="background: linear-gradient(135deg, #f0f9fc, #d4e9f5); border-color: #0b5b80;" class="rounded-lg p-6 lg:p-8 text-center border-2">
                                    <p class="text-gray-600 text-sm mb-3 font-medium">Jumlah Transfer</p>
                                    <p style="color: #0b5b80;" class="text-4xl lg:text-5xl font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                </div>

                                @if($donation->payment_method === 'bank_transfer')
                                    {{-- Bank Transfer --}}
                                    <div class="space-y-5">
                                        @foreach($bankAccounts as $account)
                                            <div class="border-2 border-gray-300 rounded-lg overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow">
                                                {{-- Bank Header --}}
                                                <div style="background-color: #0b5b80;" class="px-5 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                                    <div class="text-white">
                                                        <p class="font-bold text-base">{{ $account->bank_name }}</p>
                                                        <p class="text-sm opacity-90">{{ $account->account_holder_name }}</p>
                                                    </div>
                                                    <button type="button" class="copy-account bg-white text-gray-800 px-4 py-2 rounded font-medium hover:bg-gray-100 transition-colors text-sm whitespace-nowrap" data-account="{{ $account->account_number }}">
                                                        <i class="fas fa-copy"></i> Salin
                                                    </button>
                                                </div>

                                                {{-- Account Details --}}
                                                <div class="p-5 space-y-4">
                                                    <div>
                                                        <p class="text-xs text-gray-600 mb-2 font-medium">Nomor Rekening</p>
                                                        <p class="font-mono font-bold text-xl text-gray-800 break-all">{{ $account->account_number }}</p>
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-gray-600 mb-2 font-medium">Atas Nama</p>
                                                        <p class="font-medium text-gray-800">{{ $account->account_holder_name }}</p>
                                                    </div>

                                                    {{-- QRIS Alternative --}}
                                                    @if($account->qris_merchant_file)
                                                    <div class="border-t pt-4">
                                                        <p class="text-xs text-gray-600 mb-3 text-center font-medium"><i class="fas fa-qrcode" style="color: #0b5b80;"></i> Atau Scan QRIS</p>
                                                        <img src="{{ asset('storage/' . $account->qris_merchant_file) }}" alt="QRIS Merchant" class="w-32 h-32 mx-auto rounded-lg shadow-sm">
                                                    </div>
                                                    @endif

                                                    @if($account->description)
                                                    <div class="text-sm text-gray-600 border-t pt-4">{{ $account->description }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Instruksi Pembayaran --}}
                                    <div style="background-color: #f9fafb;" class="rounded-lg p-5 lg:p-6 border border-gray-300">
                                        <h5 class="font-bold text-gray-800 mb-4 text-base">
                                            <i class="fas fa-list-check" style="color: #0b5b80;"></i> Cara Transfer
                                        </h5>
                                        <div class="space-y-3 text-sm lg:text-base text-gray-700">
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">1.</span>
                                                <span>Buka aplikasi mobile banking atau ATM pilihan Anda</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">2.</span>
                                                <span>Pilih opsi "Transfer ke Bank Lain"</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">3.</span>
                                                <span>Masukkan nomor rekening dan nama penerima sesuai di atas</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">4.</span>
                                                <span>Masukkan jumlah: <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong></span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">5.</span>
                                                <span>Konfirmasi dan masukkan PIN atau OTP dari bank Anda</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">6.</span>
                                                <span>Transfer selesai dan tunggu notifikasi dari kami</span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($donation->payment_method === 'dana')
                                    {{-- Dana Payment --}}
                                    <div class="space-y-5">
                                        @php $hasDana = $bankAccounts->where('dana_account', '!=', null)->count() > 0; @endphp
                                        
                                        @if($hasDana)
                                            @foreach($bankAccounts as $account)
                                                @if($account->dana_account)
                                                <div class="border-2 border-gray-300 rounded-lg p-5 lg:p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
                                                    <div class="flex items-center gap-3 mb-4">
                                                        <i class="fas fa-wallet text-2xl" style="color: #3cbaff;"></i>
                                                        <div>
                                                            <p class="font-bold text-gray-800">Dana Wallet</p>
                                                            <p class="text-sm text-gray-600">{{ $account->account_holder_name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 rounded-lg p-4">
                                                        <p class="text-xs text-gray-600 mb-2">Nomor Dana:</p>
                                                        <p class="font-mono font-bold text-lg text-gray-800">{{ $account->dana_account }}</p>
                                                    </div>
                                                    <button type="button" class="copy-account w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition" data-account="{{ $account->dana_account }}">
                                                        <i class="fas fa-copy"></i> Salin Nomor Dana
                                                    </button>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-5 lg:p-6">
                                                <p class="text-sm lg:text-base text-yellow-800"><i class="fas fa-exclamation-circle"></i> Dana account belum tersedia. Hubungi admin.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Dana Instructions --}}
                                    @if($hasDana)
                                    <div style="background-color: #f9fafb;" class="rounded-lg p-5 lg:p-6 border border-gray-300">
                                        <h5 class="font-bold text-gray-800 mb-4 text-base">
                                            <i class="fas fa-list-check" style="color: #0b5b80;"></i> Cara Kirim via Dana
                                        </h5>
                                        <div class="space-y-3 text-sm lg:text-base text-gray-700">
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">1.</span>
                                                <span>Buka aplikasi Dana</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">2.</span>
                                                <span>Pilih opsi "Kirim Uang"</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">3.</span>
                                                <span>Masukkan nomor Dana penerima di atas</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">4.</span>
                                                <span>Input nominal: <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong></span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">5.</span>
                                                <span>Konfirmasi dan selesaikan pembayaran</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @elseif($donation->payment_method === 'gopay')
                                    {{-- GoPay Payment --}}
                                    <div class="space-y-5">
                                        @php $hasGopay = $bankAccounts->where('gopay_account', '!=', null)->count() > 0; @endphp
                                        
                                        @if($hasGopay)
                                            @foreach($bankAccounts as $account)
                                                @if($account->gopay_account)
                                                <div class="border-2 border-gray-300 rounded-lg p-5 lg:p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
                                                    <div class="flex items-center gap-3 mb-4">
                                                        <i class="fas fa-mobile-alt text-2xl" style="color: #00b050;"></i>
                                                        <div>
                                                            <p class="font-bold text-gray-800">GoPay</p>
                                                            <p class="text-sm text-gray-600">{{ $account->account_holder_name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 rounded-lg p-4">
                                                        <p class="text-xs text-gray-600 mb-2">Nomor GoPay:</p>
                                                        <p class="font-mono font-bold text-lg text-gray-800">{{ $account->gopay_account }}</p>
                                                    </div>
                                                    <button type="button" class="copy-account w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition" data-account="{{ $account->gopay_account }}">
                                                        <i class="fas fa-copy"></i> Salin Nomor GoPay
                                                    </button>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-5 lg:p-6">
                                                <p class="text-sm lg:text-base text-yellow-800"><i class="fas fa-exclamation-circle"></i> GoPay account belum tersedia. Hubungi admin.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- GoPay Instructions --}}
                                    @if($hasGopay)
                                    <div style="background-color: #f9fafb;" class="rounded-lg p-5 lg:p-6 border border-gray-300">
                                        <h5 class="font-bold text-gray-800 mb-4 text-base">
                                            <i class="fas fa-list-check" style="color: #0b5b80;"></i> Cara Pembayaran GoPay
                                        </h5>
                                        <div class="space-y-3 text-sm lg:text-base text-gray-700">
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">1.</span>
                                                <span>Buka aplikasi GoPay (Gojek/Google Pay)</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">2.</span>
                                                <span>Pilih opsi "Kirim Uang" atau "Send Money"</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">3.</span>
                                                <span>Masukkan nomor GoPay penerima di atas</span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">4.</span>
                                                <span>Input nominal: <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong></span>
                                            </div>
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 font-bold w-6 text-center" style="color: #0b5b80;">5.</span>
                                                <span>Konfirmasi dengan PIN/Biometrik</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif

                                {{-- Informasi Penting --}}
                                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-5 lg:p-6">
                                    <div class="flex gap-3">
                                        <i class="fas fa-info-circle text-blue-600 flex-shrink-0 mt-1 text-lg lg:text-xl"></i>
                                        <div class="text-sm lg:text-base text-blue-900">
                                            <p class="font-bold mb-2">Perhatian Penting</p>
                                            <ul class="list-disc list-inside space-y-2">
                                                <li>Pastikan nominal transfer <strong>tepat</strong> sesuai yang diminta</li>
                                                <li>Notifikasi pembayaran otomatis akan dikirim ke email Anda</li>
                                                <li>Proses verifikasi dapat memakan waktu hingga 5 menit</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Widget Pembayaran -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Status Pembayaran</h3>
                    
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                            <i class="fas fa-hourglass-half text-2xl text-yellow-600"></i>
                        </div>
                        <p class="text-sm text-gray-600">Status: <strong>{{ ucfirst($donation->status) }}</strong></p>
                    </div>

                    @if($donation->payment_method === 'qris')
                        <!-- Snap Container untuk QRIS -->
                        <div id="snap-container"></div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800">
                                Silakan transfer ke rekening bank di atas sebesar <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    @endif

                    <button type="button" id="check-status-btn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 mb-3">
                        Cek Status Pembayaran
                    </button>

                    <a href="{{ route('donations.create') }}" style="color: #0b5b80;" class="block text-center hover:opacity-70 text-sm font-medium py-2">
                        Kembali
                    </a>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500">Keamanan dijamin dengan teknologi terkini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($donation->payment_method === 'qris')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Snap initialization jika ada token
        @if($donation->payment_token)
            snap.embed('{{ $donation->payment_token }}', {
                embedId: 'snap-container',
                onSuccess: function(result){
                    window.location.href = "{{ route('donations.show', $donation) }}";
                },
                onPending: function(result){
                    console.log('pending', result);
                },
                onError: function(result){
                    console.log('error', result);
                }
            });
        @endif
    });
</script>
@endif

<script>
    document.getElementById('check-status-btn').addEventListener('click', function() {
        fetch("{{ route('donations.checkStatus', $donation) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Pembayaran berhasil!');
                window.location.href = "{{ route('donations.show', $donation) }}";
            } else if (data.status === 'pending') {
                alert('Pembayaran masih menunggu konfirmasi...');
            } else {
                alert('Status pembayaran: ' + data.status);
            }
        });
    });

    // Copy account number
    document.querySelectorAll('.copy-account').forEach(btn => {
        btn.addEventListener('click', function() {
            const accountNumber = this.dataset.account;
            navigator.clipboard.writeText(accountNumber).then(() => {
                const originalText = this.innerText;
                this.innerText = 'Tersalin!';
                setTimeout(() => {
                    this.innerText = originalText;
                }, 2000);
            });
        });
    });
</script>
@endsection
