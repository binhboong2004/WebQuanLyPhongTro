<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartRent Admin - Hệ thống quản lý phòng trọ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/danhsachtaikhoan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/capmoitaikhoan.css') }}">
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        @include('admin.partials.header')
        <main class="flex-1 flex flex-col overflow-hidden">
            @yield('content')
        </main>
    </div>
    <div id="preview-modal"
        class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 transition-all duration-300"
        onclick="closePreview()">
        <div class="relative max-w-2xl w-full flex flex-col items-center" onclick="event.stopPropagation()">
            <button onclick="closePreview()"
                class="absolute -top-12 right-0 text-white text-3xl hover:text-red-400">&times;</button>
            <img id="modal-img" src="" class="max-h-[80vh] w-auto rounded-2xl shadow-2xl border-4 border-white/10">
        </div>
    </div>
    <script src="{{ asset('js/admin/script.js') }}"></script>
    <script src="{{ asset('js/admin/danhsachtaikhoan.js') }}"></script>
    <script src="{{ asset('js/admin/capmoitaikhoan.js') }}"></script>
</body>

</html>