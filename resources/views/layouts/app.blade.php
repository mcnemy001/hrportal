<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HR Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <!-- Navigation -->
    @auth
    <nav class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-700 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8"> <!-- Added space-x-8 for consistent spacing -->
                    <!-- Logo with increased right margin and padding -->
                    <div class="flex-shrink-0 flex items-center px-4">
                        <img src="{{ asset('assets/logo_1.png') }}" alt="HR Portal Logo" class="h-12 w-auto transition-transform duration-300 hover:scale-110">
                    </div>

                    <!-- Navigation Links with improved spacing -->
                    <div class="hidden sm:-my-px sm:flex sm:space-x-6"> <!-- Increased space-x-6 -->
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-chart-line mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.pegawai.index') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('admin.pegawai.*') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-users mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Pegawai
                            </a>
                            <a href="{{ route('admin.kontrak.index') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('admin.kontrak.*') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-file-contract mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Kontrak
                            </a>
                        @else
                            <a href="{{ route('employee.dashboard') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('employee.dashboard') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-chart-line mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('employee.profile') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('employee.profile') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-user mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Profile
                            </a>
                            <a href="{{ route('employee.kontrak') }}" 
                               class="group px-6 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200
                                    {{ request()->routeIs('employee.kontrak') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                                <i class="fas fa-file-contract mr-3 group-hover:transform group-hover:translate-y-px transition-transform"></i>
                                Kontrak
                            </a>
                        @endif
                    </div>
                </div>

                <!-- User Dropdown with improved spacing -->
                <div class="flex items-center">
                    <div class="relative">
                        <div class="flex items-center space-x-8"> <!-- Increased space-x-8 -->
                            <div class="flex items-center space-x-4"> <!-- Increased space-x-4 -->
                                <div class="w-10 h-10 rounded-full bg-gray-700/50 flex items-center justify-center shadow-inner">
                                    <i class="fas fa-user text-gray-300"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-300">{{ auth()->user()->username }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center px-6 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition-all duration-200 hover:shadow-md">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Rest of the content remains the same -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Toast Notifications -->
    <div id="toast" class="fixed bottom-4 right-4 z-50 hidden transform transition-all duration-300 ease-in-out">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span id="toast-message"></span>
        </div>
    </div>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            toast.classList.add('translate-y-0');
            toast.classList.remove('translate-y-full');
            
            setTimeout(() => {
                toast.classList.add('translate-y-full');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }, 3000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>