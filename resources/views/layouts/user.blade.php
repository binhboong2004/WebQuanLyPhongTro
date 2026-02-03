<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - SmartRent</title>
    <link rel="stylesheet" href="{{ asset('css/user/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-slate-50 font-sans">

    <button id="menu-toggle" class="lg:hidden fixed top-4 left-4 z-50 bg-teal-600 text-white p-2 rounded-lg shadow-lg">
        <i class="fa fa-bars"></i>
    </button>

    <div class="flex h-screen overflow-hidden">
        @include('user.partials.header')
        <main class="flex-1 flex flex-col overflow-hidden">
            @yield('content')
        </main>
    </div>

    <div id="modal-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div id="modal-box" class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl relative">
            <button onclick="closeModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600"><i class="fa fa-times text-xl"></i></button>
            <div id="modal-content"></div>
        </div>
    </div>

    <script src="{{ asset('js/user/script.js') }}"></script>
</body>
</html>
