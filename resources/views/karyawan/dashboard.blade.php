@extends('layouts.app')

@section('title', 'Dashboard Karyawan')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Profile Card -->
    <div class="bg-dark-50 rounded-lg shadow-lg p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-100">{{ $pegawai->nama_lengkap }}</h2>
                <p class="text-gray-400 mt-1">NIP: {{ $pegawai->nip }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $pegawai->status_pegawai === 'aktif' ? 'bg-green-500 bg-opacity-20 text-green-500' : 'bg-red-500 bg-opacity-20 text-red-500' }}">
                {{ ucfirst($pegawai->status_pegawai) }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <h3 class="text-lg font-medium text-gray-300 mb-3">Informasi Pribadi</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400">Tempat, Tanggal Lahir</span>
                        <p class="text-gray-100">
                            {{ $pegawai->tempat_lahir }}, 
                            {{ $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400">Jenis Kelamin</span>
                        <p class="text-gray-100">
                            {{ $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400">Pendidikan Terakhir</span>
                        <p class="text-gray-100">{{ $pegawai->pendidikan_terakhir ?? '-' }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-300 mb-3">Kontak</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400">Alamat</span>
                        <p class="text-gray-100">{{ $pegawai->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">No. Telepon</span>
                        <p class="text-gray-100">{{ $pegawai->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Email</span>
                        <p class="text-gray-100">{{ $pegawai->email ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontrak Aktif -->
    @if($kontrakAktif)
    <div class="bg-dark-50 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Kontrak Aktif</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <span class="text-gray-400 text-sm">Nomor Kontrak</span>
                <p class="text-gray-100 font-medium">{{ $kontrakAktif->nomor_kontrak }}</p>
            </div>
            <div>
                <span class="text-gray-400 text-sm">Jenis Kontrak</span>
                <p class="text-gray-100 font-medium">{{ ucfirst($kontrakAktif->jenis_kontrak) }}</p>
            </div>
            <div>
                <span class="text-gray-400 text-sm">Tanggal Mulai</span>
                <p class="text-gray-100 font-medium">{{ $kontrakAktif->tanggal_mulai->format('d/m/Y') }}</p>
            </div>
            <div>
                <span class="text-gray-400 text-sm">Tanggal Berakhir</span>
                <p class="text-gray-100 font-medium">
                    {{ $kontrakAktif->tanggal_berakhir->format('d/m/Y') }}
                    @if($kontrakAktif->sisa_hari <= 30)
                        <span class="ml-2 px-2 py-1 text-xs rounded-full 
                            {{ $kontrakAktif->sisa_hari <= 7 ? 'bg-red-500 bg-opacity-20 text-red-500' : 'bg-yellow-500 bg-opacity-20 text-yellow-500' }}">
                            {{ $kontrakAktif->sisa_hari }} hari lagi
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Riwayat Kontrak -->
    <div class="bg-dark-50 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Riwayat Kontrak</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left bg-dark-100">
                        <th class="p-4 text-gray-300">Nomor Kontrak</th>
                        <th class="p-4 text-gray-300">Jenis</th>
                        <th class="p-4 text-gray-300">Periode</th>
                        <th class="p-4 text-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKontrak as $kontrak)
                    <tr class="border-t border-dark-200">
                        <td class="p-4">{{ $kontrak->nomor_kontrak }}</td>
                        <td class="p-4">{{ ucfirst($kontrak->jenis_kontrak) }}</td>
                        <td class="p-4">
                            {{ $kontrak->tanggal_mulai->format('d/m/Y') }} - 
                            {{ $kontrak->tanggal_berakhir->format('d/m/Y') }}
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-sm rounded-full 
                                bg-{{ $kontrak->status_kontrak_color }}-500 bg-opacity-20 
                                text-{{ $kontrak->status_kontrak_color }}-500">
                                {{ $kontrak->status_kontrak_text }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t border-dark-200">
                        <td colspan="4" class="p-4 text-center text-gray-400">
                            Belum ada riwayat kontrak
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
