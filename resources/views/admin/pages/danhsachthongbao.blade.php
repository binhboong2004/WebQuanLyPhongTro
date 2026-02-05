@extends('layouts.admin')

@section('title', 'Danh sách thông báo')

@section('content')
<main class="flex-1 p-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold">Danh sách thông báo</h3>
        <a href="{{ route('notifications.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">
            + Gửi thông báo mới
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <table class="w-full text-left">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Ngày</th>
                    <th class="py-3 px-4">Tiêu đề</th>
                    <th class="py-3 px-4">Loại</th>
                    <th class="py-3 px-4">Nội dung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notif)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-4">{{ $notif->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-4 font-bold">{{ $notif->title }}</td>
                    <td class="py-4 px-4">
                        @if($notif->type === 'general')
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Thông thường</span>
                        @elseif($notif->type === 'alert')
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Cảnh báo</span>
                        @else
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Cập nhật</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-gray-600 truncate">{{ Str::limit($notif->content, 50) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">Chưa có thông báo nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</main>
@endsection