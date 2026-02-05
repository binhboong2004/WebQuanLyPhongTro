@extends('layouts.admin')

@section('title', 'Trả lời phản hồi')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Chi tiết phản hồi</h3>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2">
            <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
                <h4 class="text-lg font-bold mb-4">{{ $issue->title }}</h4>
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Từ: <strong>{{ optional($issue->user)->name ?? 'Ẩn danh' }}</strong></p>
                    <p class="text-sm text-gray-500">Ngày: {{ $issue->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <p class="text-gray-700">{{ $issue->content }}</p>
                </div>
            </div>

            @if($issue->responses->count() > 0)
            <div class="bg-blue-50 rounded-2xl p-6 shadow-sm mb-6">
                <h5 class="font-bold text-blue-900 mb-4">Phản hồi từ Admin</h5>
                <div class="space-y-4">
                    @foreach($issue->responses as $response)
                    <div class="bg-white p-4 rounded-lg border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-2">
                            <p class="font-bold text-blue-900">{{ $response->admin->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="text-blue-800">{{ $response->content }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
                <h5 class="font-bold mb-4">Gửi phản hồi</h5>
                <form action="{{ route('issues.storeResponse', $issue->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nội dung phản hồi</label>
                        <textarea name="content" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập nội dung phản hồi..." required>{{ old('content') }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">
                            Gửi phản hồi
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h5 class="font-bold mb-4">Cập nhật trạng thái</h5>
                <form action="{{ route('issues.updateStatus', $issue->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Trạng thái</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="open" {{ $issue->status === 'open' ? 'selected' : '' }}>Chưa giải quyết</option>
                            <option value="resolved" {{ $issue->status === 'resolved' ? 'selected' : '' }}>Đã giải quyết</option>
                            <option value="closed" {{ $issue->status === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                        </select>
                        @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600">
                            Cập nhật trạng thái
                        </button>
                        <a href="{{ route('issues.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-400">
                            Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-span-1 h-fit">
            <div class="bg-white rounded-2xl p-6 shadow-sm sticky top-8">
                <h5 class="font-bold mb-4">Thông tin</h5>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Người gửi</p>
                        <p class="font-bold">{{ optional($issue->user)->name ?? 'Ẩn danh' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Trạng thái</p>
                        @if($issue->status === 'open')
                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold inline-block">Chưa giải quyết</span>
                        @elseif($issue->status === 'resolved')
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold inline-block">Đã giải quyết</span>
                        @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold inline-block">Đã đóng</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Ngày tạo</p>
                        <p class="font-bold">{{ $issue->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection