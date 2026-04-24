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

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EFF8FF] text-[#192853]">

    <!-- SIDEBAR -->
    <x-admin.sidebar />

    <!-- MAIN -->
    <div class="ml-[230px] min-h-screen flex flex-col">


        <!-- CONTENT -->
        <div class="p-8 flex-1">
            @yield('content')
        </div>

    </div>

<!-- ===== MODAL LOGOUT ===== -->
<x-admin.logout-modal />

</body>

</html> 