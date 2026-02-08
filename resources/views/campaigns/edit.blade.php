@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Campaign</h1>
        <p class="text-gray-600 mb-8">{{ $campaign->title }}</p>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-bold text-red-800 mb-2">Ada kesalahan:</h3>
                <ul class="list-disc list-inside text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
            @csrf
            @method('PUT')

            <!-- Judul Campaign -->
            <div class="mb-6">
                <label for="title" class="block font-bold text-gray-700 mb-2">
                    Judul Campaign <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title"
                    name="title" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title', $campaign->title) }}"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Singkat -->
            <div class="mb-6">
                <label for="description" class="block font-bold text-gray-700 mb-2">
                    Deskripsi Singkat <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description"
                    name="description" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 h-20 @error('description') border-red-500 @enderror" 
                    required
                >{{ old('description', $campaign->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cerita Lengkap -->
            <div class="mb-6">
                <label for="story" class="block font-bold text-gray-700 mb-2">
                    Cerita Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="story"
                    name="story" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 h-32 @error('story') border-red-500 @enderror" 
                    required
                >{{ old('story', $campaign->story) }}</textarea>
                @error('story')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label for="category" class="block font-bold text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select 
                    id="category"
                    name="category" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('category') border-red-500 @enderror"
                    required
                >
                    <option value="kesehatan" @selected(old('category', $campaign->category) === 'kesehatan')>🏥 Kesehatan</option>
                    <option value="pendidikan" @selected(old('category', $campaign->category) === 'pendidikan')>📚 Pendidikan</option>
                    <option value="bencana" @selected(old('category', $campaign->category) === 'bencana')>⚠️ Bencana Alam</option>
                    <option value="kemanusiaan" @selected(old('category', $campaign->category) === 'kemanusiaan')>❤️ Kemanusiaan</option>
                    <option value="yatim-piatu" @selected(old('category', $campaign->category) === 'yatim-piatu')>👶 Anak Yatim/Piatu</option>
                    <option value="pesantren" @selected(old('category', $campaign->category) === 'pesantren')>🕌 Pesantren/Sekolah</option>
                    <option value="lainnya" @selected(old('category', $campaign->category) === 'lainnya')>ℹ️ Lainnya</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target Donasi -->
            <div class="mb-6">
                <label for="target_amount" class="block font-bold text-gray-700 mb-2">
                    Target Donasi (Rp) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="target_amount"
                    name="target_amount" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('target_amount') border-red-500 @enderror" 
                    value="{{ old('target_amount', $campaign->target_amount) }}"
                    step="1000"
                    min="100000"
                    required
                >
                @error('target_amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline -->
            <div class="mb-6">
                <label for="deadline" class="block font-bold text-gray-700 mb-2">
                    Batas Waktu Pengumpulan Dana <span class="text-red-500">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="deadline"
                    name="deadline" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('deadline') border-red-500 @enderror" 
                    value="{{ old('deadline', $campaign->deadline?->format('Y-m-d\TH:i')) }}"
                    required
                >
                @error('deadline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Penerima -->
            <div class="mb-6">
                <label for="recipient_name" class="block font-bold text-gray-700 mb-2">
                    Nama Penerima Donasi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="recipient_name"
                    name="recipient_name" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('recipient_name') border-red-500 @enderror" 
                    value="{{ old('recipient_name', $campaign->recipient_name) }}"
                    required
                >
                @error('recipient_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informasi Penerima -->
            <div class="mb-6">
                <label for="recipient_info" class="block font-bold text-gray-700 mb-2">
                    Informasi Penerima <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="recipient_info"
                    name="recipient_info" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 h-24 @error('recipient_info') border-red-500 @enderror" 
                    required
                >{{ old('recipient_info', $campaign->recipient_info) }}</textarea>
                @error('recipient_info')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Campaign -->
            <div class="mb-6">
                <label for="image" class="block font-bold text-gray-700 mb-2">
                    Foto Campaign
                </label>
                
                @if($campaign->image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Foto Saat Ini:</p>
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="max-w-xs rounded-lg">
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-teal-500 transition" id="dropZone">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600 font-semibold">Drag & drop foto campaign di sini</p>
                    <p class="text-gray-500 text-sm">atau</p>
                    <input 
                        type="file" 
                        id="image"
                        name="image" 
                        class="hidden"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        onchange="previewImage(this)"
                    >
                    <button type="button" class="text-teal-600 font-semibold" onclick="document.getElementById('image').click()">
                        Ubah Foto
                    </button>
                    <p class="text-gray-500 text-xs mt-2">JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="imagePreview"></div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block font-bold text-gray-700 mb-2">
                    Status Campaign <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status"
                    name="status" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-teal-500 @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="active" @selected(old('status', $campaign->status) === 'active')>Aktif</option>
                    <option value="completed" @selected(old('status', $campaign->status) === 'completed')>Selesai</option>
                    <option value="cancelled" @selected(old('status', $campaign->status) === 'cancelled')>Dibatalkan</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg transition"
                >
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition">
                    Batal
                </a>
                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition" onclick="return confirm('Yakin ingin menghapus campaign ini?')">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>

<script>
const dropZone = document.getElementById('dropZone');
const imageInput = document.getElementById('image');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-teal-500', 'bg-teal-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-teal-500', 'bg-teal-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-teal-500', 'bg-teal-50');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        previewImage(imageInput);
    }
});

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img src="${e.target.result}" alt="Preview" class="max-w-xs h-32 rounded-lg">
                    <p class="text-sm text-gray-600 mt-2">${input.files[0].name}</p>
                </div>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
