@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-200 mb-8">Edit Pegawai</h1>

        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" class="bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-300">NIP</label>
                    <input type="text" name="nip" id="nip" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('nip', $pegawai->nip) }}" required>
                    @error('nip')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-300">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" required>
                    @error('tempat_lahir')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-300">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir?->format('Y-m-d')) }}" required>
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-300">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-300">Nomor Telepon</label>
                    <input type="tel" name="nomor_telepon" id="nomor_telepon" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}" required>
                    @error('nomor_telepon')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('email', $pegawai->email) }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Pegawai -->
                <div>
                    <label for="status_pegawai" class="block text-sm font-medium text-gray-300">Status Pegawai</label>
                    <select name="status_pegawai" id="status_pegawai" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="aktif" {{ old('status_pegawai', $pegawai->status_pegawai) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status_pegawai', $pegawai->status_pegawai) === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status_pegawai')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-300">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" 
                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.pegawai.index') }}" 
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection