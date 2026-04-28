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
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-[#192853] transition">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- CONTENT -->
        <div class="p-4 md:p-8 flex-1 w-full overflow-x-hidden">
            @yield('content')
        </div>

    </div>

<!-- ===== MODAL LOGOUT ===== -->
<x-admin.logout-modal />

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
</script>

</body>

</html> 