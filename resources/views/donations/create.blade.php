@extends('layouts.app')

@section('title', 'Form Donasi')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Berikan Donasi Anda</h1>
            <p class="text-gray-600 mb-8">Setiap dukungan Anda sangat berarti bagi kami</p>

            <form action="{{ route('donations.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Donatur -->
                    <div>
                        <label for="donor_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="donor_name" id="donor_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('donor_name') border-red-500 @enderror" placeholder="Nama Anda" value="{{ old('donor_name') }}" required>
                        @error('donor_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="donor_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="donor_email" id="donor_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('donor_email') border-red-500 @enderror" placeholder="email@example.com" value="{{ old('donor_email') }}" required>
                        @error('donor_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="donor_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon (Opsional)
                    </label>
                    <input type="tel" name="donor_phone" id="donor_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08xx xxxx xxxx" value="{{ old('donor_phone') }}">
                    @error('donor_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Judul Kampanye -->
                <div>
                    <label for="campaign_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Kampanye (Opsional)
                    </label>
                    <input type="text" name="campaign_title" id="campaign_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Bantuan Bencana Alam" value="{{ old('campaign_title') }}">
                    @error('campaign_title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah Donasi -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Donasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-2">Rp</span>
                        <input type="number" name="amount" id="amount" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror" placeholder="50000" min="10000" step="1000" value="{{ old('amount') }}" required>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Minimum: Rp 10.000</p>
                    @error('amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Pesan -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Pesan Pribadi (Opsional)
                    </label>
                    <textarea name="message" id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror" placeholder="Tambahkan pesan doa atau dukungan...">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Pilih Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition @error('payment_method') border-red-500 @enderror" for="payment_qris">
                        <input type="radio" name="payment_method" id="payment_qris" value="qris" style="accent-color: #0b5b80;" class="w-5 h-5 rounded" checked required>
                            <div class="ml-4">
                                <span class="font-medium text-gray-800">QRIS</span>
                                <p class="text-sm text-gray-600">Scan kode QR untuk membayar</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition" for="payment_bank">
                            <input type="radio" name="payment_method" id="payment_bank" value="bank_transfer" style="accent-color: #0b5b80;" class="w-5 h-5 rounded" required>
                            <div class="ml-4">
                                <span class="font-medium text-gray-800">Transfer Bank</span>
                                <p class="text-sm text-gray-600">Transfer langsung ke rekening kami</p>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>

                <!-- Button Submit -->
                <button type="submit" style="background-color: #0b5b80;" class="w-full hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    Lanjut ke Pembayaran
                </button>
            </form>

            <p class="text-center text-gray-500 text-sm mt-6">
                Donasi Anda dilindungi dengan protokol keamanan terbaru
            </p>
        </div>
    </div>
</div>
@endsection
