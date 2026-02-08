@extends('layouts.app')

@section('title', 'Daftar Campaign Donasi')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-teal-700 to-teal-800 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Campaign Donasi</h1>
            <p class="text-teal-100">Bantu sesama dengan mendukung campaign penting</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        @if(auth()->check() && auth()->user()->is_admin)
            <div class="mb-8">
                <a href="{{ route('campaigns.create') }}" class="inline-flex items-center bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Campaign Baru
                </a>
            </div>
        @endif

        @if($campaigns->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg">Belum ada campaign saat ini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($campaigns as $campaign)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <!-- Campaign Image -->
                        <div class="relative h-48 bg-gradient-to-r from-teal-600 to-teal-700 overflow-hidden">
                            @if($campaign->image)
                                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-white text-5xl opacity-50"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 right-3 bg-white text-teal-700 px-3 py-1 rounded-full text-sm font-semibold">
                                @switch($campaign->category)
                                    @case('kesehatan')
                                        🏥 Kesehatan
                                        @break
                                    @case('pendidikan')
                                        📚 Pendidikan
                                        @break
                                    @case('bencana')
                                        ⚠️ Bencana
                                        @break
                                    @case('kemanusiaan')
                                        ❤️ Kemanusiaan
                                        @break
                                    @case('yatim-piatu')
                                        👶 Yatim Piatu
                                        @break
                                    @case('pesantren')
                                        🕌 Pesantren
                                        @break
                                    @default
                                        ℹ️ Lainnya
                                @endswitch
                            </div>
                        </div>

                        <!-- Campaign Info -->
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $campaign->description }}</p>

                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-semibold text-teal-700">
                                        Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ round($campaign->getProgressPercentage()) }}%
                                    </span>
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

                            <!-- Donor Count & Deadline -->
                            <div class="flex justify-between items-center text-sm text-gray-600 mb-4 pb-4 border-b">
                                <span><i class="fas fa-users text-teal-600 mr-1"></i> {{ $campaign->getDonorCount() }} donatur</span>
                                @if($campaign->deadline)
                                    <span>
                                        <i class="fas fa-clock text-teal-600 mr-1"></i>
                                        {{ $campaign->deadline->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-2 rounded text-center text-sm font-semibold transition">
                                    Lihat Detail
                                </a>
                                @if(auth()->check() && auth()->user()->is_admin)
                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
