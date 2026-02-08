<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekening Bank</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 font-medium transition">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>

                    <!-- Kelola Rekening Bank -->
                    <a href="{{ route('admin.bank-accounts.index') }}" style="background-color: #0b5b80;" class="text-white font-medium transition flex items-center gap-3 px-4 py-3 rounded-lg">
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
            <div class="max-w-2xl">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Rekening Bank</h1>
                    <p class="text-gray-600 mb-8">Tambahkan rekening bank baru untuk menerima donasi</p>

            <form action="{{ route('admin.bank-accounts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Bank Name -->
                <div>
                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Bank <span class="text-red-500">*</span>
                    </label>
                    <select name="bank_name" id="bank_name" style="border-color: #ccc; focus-within: outline-offset 0; focus-within: border-color #0b5b80;" class="w-full px-4 py-2 rounded-lg @error('bank_name') border-red-500 @enderror" required>
                        <option value="">Pilih Bank</option>
                        <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BTN" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>BTN</option>
                        <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                        <option value="Danamon" {{ old('bank_name') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                        <option value="OVO" {{ old('bank_name') == 'OVO' ? 'selected' : '' }}>OVO</option>
                        <option value="Dana" {{ old('bank_name') == 'Dana' ? 'selected' : '' }}>Dana</option>
                        <option value="GCash" {{ old('bank_name') == 'GCash' ? 'selected' : '' }}>GCash</option>
                        <option value="Other" {{ old('bank_name') == 'Other' ? 'selected' : '' }}>Bank Lainnya</option>
                    </select>
                    @error('bank_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Account Number -->
                <div>
                    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Rekening <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_number" id="account_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('account_number') border-red-500 @enderror" placeholder="1234567890" value="{{ old('account_number') }}" required>
                    @error('account_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Account Holder Name -->
                <div>
                    <label for="account_holder_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pemilik Rekening <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_holder_name" id="account_holder_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('account_holder_name') border-red-500 @enderror" placeholder="Nama lengkap" value="{{ old('account_holder_name') }}" required>
                    @error('account_holder_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- QRIS Merchant File Upload -->
                <div>
                    <label for="qris_merchant_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload QRIS Merchant (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-gray-400 transition" id="dropzone">
                        <input type="file" name="qris_merchant_file" id="qris_merchant_file" accept="image/*" class="hidden" />
                        <div class="space-y-2">
                            <i class="fas fa-qrcode text-3xl" style="color: #0b5b80;"></i>
                            <p class="text-gray-600">Drag & drop gambar QRIS atau klik untuk upload</p>
                            <p class="text-xs text-gray-500">Format: JPG, PNG (Max 2MB)</p>
                        </div>
                    </div>
                    <div id="preview" class="mt-3 hidden">
                        <img id="previewImage" src="" alt="Preview" class="max-w-xs mx-auto rounded-lg border">
                    </div>
                    @error('qris_merchant_file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Dana Account -->
                <div>
                    <label for="dana_account" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Dana (Opsional)
                    </label>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-2"><i class="fas fa-wallet"></i></span>
                        <input type="text" name="dana_account" id="dana_account" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('dana_account') border-red-500 @enderror" placeholder="08xx xxxx xxxx atau email Dana" value="{{ old('dana_account') }}">
                    </div>
                    @error('dana_account')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- GoPay Account -->
                <div>
                    <label for="gopay_account" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor GoPay (Opsional)
                    </label>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-2"><i class="fas fa-mobile-alt"></i></span>
                        <input type="text" name="gopay_account" id="gopay_account" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gopay_account') border-red-500 @enderror" placeholder="08xx xxxx xxxx atau email GoPay" value="{{ old('gopay_account') }}">
                    </div>
                    @error('gopay_account')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" placeholder="Contoh: Rekening utama untuk donasi bulanan">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Is Active -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" style="accent-color: #0b5b80;" class="w-4 h-4 rounded" checked>
                        <span class="ml-2 text-gray-700">Aktifkan rekening ini</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" style="background-color: #0b5b80;" class="flex-1 hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg transition">
                        Simpan Rekening
                    </button>
                    <a href="{{ route('admin.bank-accounts.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
        </main>
    </div>

<script>
    // Handle drag & drop file upload
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('qris_merchant_file');
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('previewImage');

    dropzone.addEventListener('click', () => fileInput.click());

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            showPreview(files[0]);
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            showPreview(e.target.files[0]);
        }
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>

</body>
</html>
