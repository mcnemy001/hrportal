@extends('layouts.app')

@section('title', 'Informasi Kontrak')
@section('header', 'Informasi Kontrak')

@section('content')
<div class="space-y-8">
    <!-- Kontrak Timeline -->
    <div class="bg-dark-50 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-6">Timeline Kontrak</h2>
        <div class="space-y-8">
            @forelse($kontrak as $item)
            <div class="relative pl-8 pb-8 last:pb-0">
                <!-- Timeline line -->
                <div class="absolute left-0 top-0 bottom-0 w-px bg-dark-200"></div>
                
                <!-- Timeline dot -->
                <div class="absolute left-[-5px] top-0 w-[10px] h-[10px] rounded-full
                    {{ $item->status_kontrak === 'aktif' ? 'bg-primary' : 'bg-gray-500' }}">
                </div>

                <!-- Content -->
                <div class="bg-dark-100 rounded-lg p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-100">{{ $item->nomor_kontrak }}</h3>
                            <p class="text-gray-400 mt-1">{{ ucfirst($item->jenis_kontrak) }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm 
                            bg-{{ $item->status_kontrak_color }}-500 bg-opacity-20 
                            text-{{ $item->status_kontrak_color }}-500">
                            {{ $item->status_kontrak_text }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <span class="text-gray-400 text-sm">Tanggal Mulai</span>
                            <p class="text-gray-100">{{ $item->tanggal_mulai->format('d F Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm">Tanggal Berakhir</span>
                            <p class="text-gray-100">
                                {{ $item->tanggal_berakhir->format('d F Y') }}
                                @if($item->status_kontrak === 'aktif' && $item->sisa_hari <= 30)
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                        {{ $item->sisa_hari <= 7 ? 'bg-red-500 bg-opacity-20 text-red-500' : 'bg-yellow-500 bg-opacity-20 text-yellow-500' }}">
                                        {{ $item->sisa_hari }} hari lagi
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm">Durasi</span>
                            <p class="text-gray-100">
                                {{ $item->tanggal_mulai->diffInMonths($item->tanggal_berakhir) }} bulan
                            </p>
                        </div>
                    </div>

                    @if($item->keterangan)
                    <div class="mt-4">
                        <span class="text-gray-400 text-sm">Keterangan</span>
                        <p class="text-gray-100 mt-1">{{ $item->keterangan }}</p>
                    </div>
                    @endif

                    @if($item->riwayat->isNotEmpty())
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-300 mb-3">Riwayat Perubahan</h4>
                        <div class="space-y-3">
                            @foreach($item->riwayat as $riwayat)
                            <div class="flex items-start space-x-3 text-sm">
                                <div class="flex-shrink-0">
                                    <span class="px-2 py-1 rounded-full bg-dark-200 text-gray-400">
                                        {{ $riwayat->tanggal_perubahan->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-primary">{{ ucfirst($riwayat->jenis_perubahan) }}</span>
                                    <p class="text-gray-400 mt-1">{{ $riwayat->keterangan }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-8">
                Belum ada data kontrak
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
