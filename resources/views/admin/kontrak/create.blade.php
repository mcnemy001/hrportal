@extends('layouts.app')

@section('title', 'Tambah Kontrak')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-200 mb-8">Tambah Kontrak Baru</h1>

        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.kontrak.store') }}" method="POST" class="bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pegawai -->
                <div class="md:col-span-2">
                    <label for="pegawai_id" class="block text-sm font-medium text-gray-300">Pegawai</label>
                    <select name="pegawai_id" id="pegawai_id" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Pegawai</option>
                        @foreach($pegawai as $p)
                        <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_lengkap }} ({{ $p->nip }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nomor Kontrak -->
                <div>
                    <label for="nomor_kontrak" class="block text-sm font-medium text-gray-300">Nomor Kontrak</label>
                    <input type="text" name="nomor_kontrak" id="nomor_kontrak" value="{{ old('nomor_kontrak') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Gaji Pokok -->
                <div>
                    <label for="gaji_pokok" class="block text-sm font-medium text-gray-300">Gaji Pokok</label>
                    <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-300">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Tanggal Berakhir -->
                <div>
                    <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-300">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-300">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.kontrak.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
