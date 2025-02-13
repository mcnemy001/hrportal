@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-200 mb-8">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Pegawai -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Pegawai</p>
                    <p class="text-2xl font-bold text-gray-200">{{ $totalPegawai }}</p>
                </div>
                <div class="p-3 bg-blue-500 bg-opacity-20 rounded-full">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kontrak Aktif -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Kontrak Aktif</p>
                    <p class="text-2xl font-bold text-gray-200">{{ $totalKontrakAktif }}</p>
                </div>
                <div class="p-3 bg-green-500 bg-opacity-20 rounded-full">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kontrak Berakhir -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Kontrak Berakhir</p>
                    <p class="text-2xl font-bold text-gray-200">{{ $totalKontrakBerakhir }}</p>
                </div>
                <div class="p-3 bg-yellow-500 bg-opacity-20 rounded-full">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Contracts -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-200 mb-2 mt-6">Kontrak Terbaru</h2>
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden overflow-x-auto">
            <table class="w-full table-auto divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Pegawai
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Nomor Kontrak
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Tanggal Mulai
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Tanggal Berakhir
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse ($latestKontraks as $kontrak)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">
                                {{ $kontrak->pegawai->nama_lengkap }}
                                <div class="text-xs text-gray-400">{{ $kontrak->pegawai->nip }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">{{ $kontrak->nomor_kontrak }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">{{ $kontrak->tanggal_mulai->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">{{ $kontrak->tanggal_berakhir->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full 
                                {{ $kontrak->status === 'active' ? 'bg-green-500 bg-opacity-20 text-green-500' : 'bg-red-500 bg-opacity-20 text-red-500' }}">
                                {{ $kontrak->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                            Tidak ada data kontrak
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
