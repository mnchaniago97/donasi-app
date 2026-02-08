@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Campaign Header -->
    <div class="relative h-96 bg-gradient-to-r from-teal-700 to-teal-800 overflow-hidden">
        @if($campaign->image)
            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover opacity-80">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        
        <div class="absolute inset-0 flex items-end">
            <div class="container mx-auto px-4 pb-8 w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">{{ $campaign->title }}</h1>
                        <p class="text-teal-100 text-lg">{{ $campaign->recipient_name }}</p>
                    </div>
                    @if(auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('campaigns.edit', $campaign) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                            <i class="fas fa-edit mr-2"></i>Edit Campaign
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Category & Status -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex gap-4 mb-4">
                        <span class="inline-block bg-teal-100 text-teal-800 px-4 py-2 rounded-full font-semibold">
                            @switch($campaign->category)
                                @case('kesehatan')
                                    🏥 Kesehatan
                                    @break
                                @case('pendidikan')
                                    📚 Pendidikan
                                    @break
                                @case('bencana')
                                    ⚠️ Bencana Alam
                                    @break
                                @case('kemanusiaan')
                                    ❤️ Kemanusiaan
                                    @break
                                @case('yatim-piatu')
                                    👶 Anak Yatim
                                    @break
                                @case('pesantren')
                                    🕌 Pesantren
                                    @break
                                @default
                                    ℹ️ Lainnya
                            @endswitch
                        </span>
                        @if($campaign->isGoalReached())
                            <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                                ✓ Target Tercapai
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description & Story -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Tentang Campaign</h2>
                    <p class="text-gray-700 mb-6">{{ $campaign->description }}</p>
                    
                    <h3 class="text-xl font-bold mb-3">Cerita Lengkap</h3>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($campaign->story)) !!}
                    </div>

                    <h3 class="text-xl font-bold mt-8 mb-3">Tentang Penerima</h3>
                    <div class="bg-teal-50 border-l-4 border-teal-600 p-4">
                        {!! nl2br(e($campaign->recipient_info)) !!}
                    </div>
                </div>

                <!-- Campaign Updates -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6">Update Campaign</h2>

                    @if(auth()->check() && auth()->user()->is_admin)
                        <form action="{{ route('campaigns.storeUpdate', $campaign) }}" method="POST" class="mb-6 pb-6 border-b">
                            @csrf
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Judul Update</label>
                                <input type="text" name="title" class="w-full border rounded-lg px-4 py-2" placeholder="Judul update campaign" required>
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Isi Update</label>
                                <textarea name="content" class="w-full border rounded-lg px-4 py-2 h-24" placeholder="Tuliskan update campaign..." required></textarea>
                            </div>
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i>Tambah Update
                            </button>
                        </form>
                    @endif

                    @forelse($campaign->updates as $update)
                        <div class="mb-6 pb-6 border-b last:border-b-0 last:mb-0 last:pb-0">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg">{{ $update->title }}</h3>
                                <span class="text-sm text-gray-500">{{ $update->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 whitespace-pre-line">{{ $update->content }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-6">Belum ada update dari campaign ini</p>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Progress Card -->
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20 mb-6">
                    <h3 class="font-bold text-lg mb-4">Progress Dana</h3>
                    
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-teal-600 mb-2">
                            Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}
                        </div>
                        <p class="text-gray-600 mb-4">dari target Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>

                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div 
                                class="bg-teal-600 h-3 rounded-full transition-all duration-300"
                                style="width: {{ $campaign->getProgressPercentage() }}%"
                            ></div>
                        </div>
                        <p class="text-center font-bold text-teal-600">{{ round($campaign->getProgressPercentage()) }}%</p>
                    </div>

                    <div class="space-y-2 text-sm mb-6 pb-6 border-b">
                        <div class="flex justify-between">
                            <span class="text-gray-600"><i class="fas fa-users text-teal-600 mr-2"></i>Donatur</span>
                            <span class="font-semibold">{{ $donorCount }}</span>
                        </div>
                        @if($campaign->deadline)
                            <div class="flex justify-between">
                                <span class="text-gray-600"><i class="fas fa-calendar text-teal-600 mr-2"></i>Berakhir</span>
                                <span class="font-semibold">{{ $campaign->deadline->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600"><i class="fas fa-hourglass-end text-teal-600 mr-2"></i>Sisa Waktu</span>
                                <span class="font-semibold">{{ $campaign->deadline->diffForHumans() }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Donation Button -->
                    <a href="{{ route('donations.create', ['campaign_id' => $campaign->id]) }}" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg text-center transition block">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </a>

                    <!-- Share Buttons -->
                    <div class="mt-6 pt-6 border-t">
                        <p class="text-sm font-semibold mb-3">Bagikan Campaign</p>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-center text-sm transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ $campaign->title }}&url={{ url()->current() }}" target="_blank" class="flex-1 bg-blue-400 hover:bg-blue-500 text-white py-2 rounded text-center text-sm transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($campaign->title . ' ' . url()->current()) }}" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded text-center text-sm transition">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <button onclick="copyLink()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded text-center text-sm transition">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Top Donors -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4">🏆 Top Donatur</h3>
                    
                    @forelse($topDonors as $index => $donor)
                        <div class="mb-4 pb-4 border-b last:border-b-0 last:mb-0 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $donor->donor_name }}</p>
                                    <p class="text-sm text-gray-600">Rp {{ number_format($donor->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-6">Belum ada donasi</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    const url = "{{ url()->current() }}";
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endsection
