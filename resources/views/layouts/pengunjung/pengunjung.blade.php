<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'EventiX - Pengunjung')</title>
    
    @vite('resources/css/app.css')
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">



    @stack('styles')
</head>
<body class="@yield('body_class')">

    <x-pengunjung.navbar-pengunjung />

    @yield('content')
    
    {{-- Notifikasi Error/Sukses --}}
    @if(session('error'))
        <div class="fixed bottom-5 right-5 z-[9999] bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg animate-bounce">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="fixed bottom-5 right-5 z-[9999] bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(request()->routeIs('home'))
        <x-pengunjung.footer-pengunjung />
    @endif

    @stack('scripts')
    
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
