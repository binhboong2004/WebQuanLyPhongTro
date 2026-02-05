@extends('layouts.admin')

@section('title', 'Danh sách phản hồi')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Danh sách phản hồi từ người dùng</h3>

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
                    <th class="py-3 px-4">Người gửi</th>
                    <th class="py-3 px-4">Tiêu đề</th>
                    <th class="py-3 px-4">Trạng thái</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-4">{{ $issue->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-4">{{ optional($issue->user)->name ?? 'Ẩn danh' }}</td>
                    <td class="py-4 px-4">{{ $issue->title }}</td>
                    <td class="py-4 px-4">
                        @if($issue->status === 'open')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">Chưa giải quyết</span>
                        @elseif($issue->status === 'resolved')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Đã giải quyết</span>
                        @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">Đã đóng</span>
                        @endif
                    </td>
                    <td class="py-4 px-4">
                        <a href="{{ route('issues.show', $issue->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs font-bold hover:bg-blue-600">
                            Trả lời
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-400">Không có phản hồi nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $issues->links() }}
        </div>
    </div>
</main>
@endsection