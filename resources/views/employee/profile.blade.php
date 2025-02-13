@extends('layouts.app')

@section('title', 'Profil Pegawai')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-200 mb-8">Profil Pegawai</h1>

        @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <form action="{{ route('employee.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Data yang tidak bisa diubah -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400">NIP</label>
                        <p class="mt-1 text-lg text-gray-300">{{ auth()->user()->pegawai->nip }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400">Nama Lengkap</label>
                        <p class="mt-1 text-lg text-gray-300">{{ auth()->user()->pegawai->nama_lengkap }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400">Tempat, Tanggal Lahir</label>
                        <p class="mt-1 text-lg text-gray-300">
                            {{ auth()->user()->pegawai->tempat_lahir }}, 
                            {{ auth()->user()->pegawai->tanggal_lahir->format('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400">Jenis Kelamin</label>
                        <p class="mt-1 text-lg text-gray-300">
                            {{ auth()->user()->pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                </div>

                <hr class="border-gray-700 my-6">

                <!-- Data yang bisa diubah -->
                <div class="space-y-6">
                    <div>
                        <label for="nomor_telepon" class="block text-sm font-medium text-gray-300">Nomor Telepon</label>
                        <input type="tel" name="nomor_telepon" id="nomor_telepon" 
                            value="{{ old('nomor_telepon', auth()->user()->pegawai->nomor_telepon) }}" required
                            class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" name="email" id="email" 
                            value="{{ old('email', auth()->user()->pegawai->email) }}" required
                            class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-300">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', auth()->user()->pegawai->alamat) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection