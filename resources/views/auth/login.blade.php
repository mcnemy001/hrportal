@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo Container -->
        <div class="flex flex-col items-center">
                <div class="flex-shrink-0 flex items-center px-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="HR Portal Logo" class="h-15 w-auto transition-transform duration-300 hover:scale-110">
                </div>
            <p class="mt-2 text-center text-sm text-gray-400">
                Masuk untuk mengakses dashboard Anda
            </p>
        </div>

        <!-- Login Form -->
        <div class="mt-8 bg-gray-800 p-8 rounded-xl shadow-2xl">
            <form class="space-y-6" action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Username Input -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                            Nama Pengguna
                        </label>
                        <input id="username" name="username" type="text" required value="{{ old('username') }}"
                            class="block w-full px-3 py-3 border border-gray-700 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            placeholder="Masukkan nama pengguna">
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Kata Sandi
                        </label>
                        <input id="password" name="password" type="password" required
                            class="block w-full px-3 py-3 border border-gray-700 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            placeholder="Masukkan kata sandi">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
