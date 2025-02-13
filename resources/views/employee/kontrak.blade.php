@extends('layouts.app')

@section('title', 'Data Kontrak')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-200 mb-8">Data Kontrak</h1>

        <!-- Kontrak Aktif -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-200 mb-4">Kontrak Aktif</h2>
            @if($kontrakAktif = auth()->user()->pegawai->kontrakAktif)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-400">Nomor Kontrak</p>
                        <p class="text-lg text-white">{{ $kontrakAktif->nomor_kontrak }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tanggal Mulai</p>
                        <p class="text-lg text-white">{{ $kontrakAktif->tanggal_mulai->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tanggal Berakhir</p>
                        <p class="text-lg text-white">{{ $kontrakAktif->tanggal_berakhir->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Gaji Pokok</p>
                        <p class="text-lg text-white">Rp {{ number_format($kontrakAktif->gaji_pokok, 0, ',', '.') }}</p>
                    </div>
                    @if($kontrakAktif->keterangan)
                    <div class="md:col-span-2">
                        <p class="text-gray-400">Keterangan</p>
                        <p class="text-white">{{ $kontrakAktif->keterangan }}</p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <p class="text-gray-400">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">
                            Aktif
                        </span>
                    </div>
                </div>
            @else
                <p class="text-gray-400">Tidak ada kontrak aktif</p>
            @endif
        </div>

        <!-- Riwayat Kontrak -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-200 mb-4">Riwayat Kontrak</h2>
            @if(auth()->user()->pegawai->kontrak->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Nomor Kontrak
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Tanggal Mulai
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Tanggal Berakhir
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Gaji Pokok
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach(auth()->user()->pegawai->kontrak as $kontrak)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $kontrak->nomor_kontrak }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $kontrak->tanggal_mulai->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $kontrak->tanggal_berakhir->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    Rp {{ number_format($kontrak->gaji_pokok, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($kontrak->tanggal_berakhir->isFuture() && $kontrak->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500 text-white">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400">Tidak ada riwayat kontrak</p>
            @endif
        </div>
    </div>
</div>
@endsection