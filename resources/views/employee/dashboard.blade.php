@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-200 mb-8">Dashboard Pegawai</h1>

        <!-- Informasi Pegawai dan Kontrak Aktif -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Informasi Pegawai -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-gray-200 mb-4">Informasi Pegawai</h2>
                <div class="space-y-4 text-gray-300">
                    <p><span class="font-medium text-gray-400">Nama:</span> {{ $pegawai->nama_lengkap }}</p>
                    <p><span class="font-medium text-gray-400">NIP:</span> {{ $pegawai->nip }}</p>
                    <p><span class="font-medium text-gray-400">Email:</span> {{ $pegawai->email }}</p>
                    <p><span class="font-medium text-gray-400">Telepon:</span> {{ $pegawai->nomor_telepon }}</p>
                    <p><span class="font-medium text-gray-400">Alamat:</span> {{ $pegawai->alamat }}</p>
                </div>
            </div>

            <!-- Kontrak Aktif -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-gray-200 mb-4">Kontrak Aktif</h2>
                <div class="space-y-4 text-gray-300">
                    @if($kontrakAktif)
                        <p><span class="font-medium text-gray-400">Nomor:</span> {{ $kontrakAktif->nomor_kontrak }}</p>
                        <p><span class="font-medium text-gray-400">Mulai:</span> {{ $kontrakAktif->tanggal_mulai->format('d F Y') }}</p>
                        <p><span class="font-medium text-gray-400">Berakhir:</span> {{ $kontrakAktif->tanggal_berakhir->format('d F Y') }}</p>
                        <p><span class="font-medium text-gray-400">Durasi:</span> {{ $kontrakAktif->tanggal_mulai->diffInMonths($kontrakAktif->tanggal_berakhir) }} bulan</p>
                        <div class="mt-2">
                            @if($kontrakAktif && $pegawai->status_pegawai == 'aktif')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500 text-white">
                                    Aktif
                                </span>
                            @elseif($pegawai->status_pegawai == 'tidak_aktif')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-500 text-white">
                                    Tidak Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-500 text-white">
                                    Berakhir
                                </span>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400">Tidak ada kontrak aktif saat ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status dan Progress -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-12">
            <h2 class="text-xl font-semibold text-gray-200 mb-4">Status Kontrak</h2>
            @if($kontrakAktif)
                @php
                    $startDate = $kontrakAktif->tanggal_mulai;
                    $endDate = $kontrakAktif->tanggal_berakhir;
                    $today = now();
                    $totalDays = $startDate->diffInDays($endDate);
                    $daysElapsed = $startDate->diffInDays($today);
                    $progress = min(($daysElapsed / $totalDays) * 100, 100);
                @endphp
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-400 mb-1">
                        <span>Progress Kontrak</span>
                        <span>{{ number_format($progress, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-300">
                    <div>
                        <span class="text-gray-400">Sisa Waktu:</span>
                        <span>{{ now()->diffInDays($kontrakAktif->tanggal_berakhir) }} hari</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Total Durasi:</span>
                        <span>{{ $totalDays }} hari</span>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-400 py-4">Tidak ada kontrak aktif untuk ditampilkan</p>
            @endif
        </div>

        <!-- Riwayat Kontrak -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-200 mb-4">Riwayat Kontrak</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-gray-300 border-collapse">
                    <thead>
                        <tr class="bg-gray-700 text-left">
                            <th class="px-6 py-3 text-xs font-medium uppercase">Nomor Kontrak</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Mulai</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Berakhir</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Durasi</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($riwayatKontrak as $kontrak)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-6 py-4 text-sm">{{ $kontrak->nomor_kontrak }}</td>
                                <td class="px-6 py-4 text-sm">{{ $kontrak->tanggal_mulai->format('d F Y') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $kontrak->tanggal_berakhir->format('d F Y') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $kontrak->tanggal_mulai->diffInMonths($kontrak->tanggal_berakhir) }} bulan</td>
                                <td class="px-6 py-4 text-sm">
                                @if($kontrak->tanggal_berakhir >= now() && $pegawai->status_pegawai == 'aktif')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500 text-white">
                                        Aktif
                                    </span>
                                @elseif($pegawai->status_pegawai == 'tidak_aktif')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-500 text-white">
                                        Tidak Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-500 text-white">
                                        Berakhir
                                    </span>
                                @endif
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-400">
                                    Tidak ada riwayat kontrak
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection