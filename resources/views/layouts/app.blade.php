<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Eventix Admin' }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-[#EFF8FF] text-[#192853]">

    <!-- SIDEBAR -->
    <x-admin.sidebar />

    <!-- MAIN -->
    <div class="md:ml-[230px] min-h-screen flex flex-col transition-all duration-300">

        <!-- MOBILE HEADER -->
        <div class="md:hidden bg-white border-b px-6 py-4 flex items-center justify-between shadow-sm sticky top-0 z-30">
            <h1 class="text-[#192853] font-bold text-lg">Eventix Admin</h1>
            <button data-drawer-target="adminSidebar" data-drawer-toggle="adminSidebar" aria-controls="adminSidebar" type="button" class="text-gray-500 hover:text-[#192853] transition">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- CONTENT -->
        <div class="p-4 md:p-8 flex-1 w-full overflow-x-hidden">
            @if(session('success'))
                <div id="toast-success" class="fixed top-6 right-6 z-[9999] bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 transition-all duration-500 animate-fade-in-down">
                    <div class="bg-white/20 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold tracking-wide">
                        {{ session('success') }}
                    </div>
                    <button type="button" onclick="document.getElementById('toast-success').remove()" class="ml-4 text-white/80 hover:text-white text-3xl font-normal leading-none" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="toast-error" class="fixed top-6 right-6 z-[9999] bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 transition-all duration-500 animate-fade-in-down">
                    <div class="bg-white/20 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold tracking-wide">
                        {{ session('error') }}
                    </div>
                    <button type="button" onclick="document.getElementById('toast-error').remove()" class="ml-4 text-white/80 hover:text-white text-3xl font-normal leading-none" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

    </div>

<!-- ===== MODAL LOGOUT ===== -->
<x-admin.logout-modal />

<!-- Flowbite -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html> 