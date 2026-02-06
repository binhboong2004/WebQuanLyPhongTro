@extends('layouts.user')
@section('title', 'Thành viên ở cùng')
@section('content')
<main class="flex-1 overflow-y-auto relative p-4 lg:p-10" data-success="{{ session('success') ? '1' : '0' }}" data-success-msg="{!! htmlspecialchars(session('success') ?? '', ENT_QUOTES, 'UTF-8') !!}">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-slate-900">Thành viên ở cùng</h2>
            <p class="text-slate-400 text-sm mt-1">Phòng: {{ $room->room_number }} - {{ $room->building->name ?? 'N/A' }}</p>
        </div>
        <div class="flex gap-3">
            @if (!isset($member))
            <button type="button" onclick="showAddForm()" class="bg-teal-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-teal-700 transition">
                <i class="fa fa-plus mr-2"></i>Thêm thành viên
            </button>
            @endif
            <a href="{{ route('user.index') }}" class="bg-slate-100 text-slate-600 px-6 py-2 rounded-lg text-sm font-bold hover:bg-slate-200 transition">
                <i class="fa fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>
    </header>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex gap-3 items-start">
        <i class="fa fa-exclamation-circle text-red-500 mt-1 flex-shrink-0"></i>
        <div>
            <p class="font-bold text-red-700 mb-2">Có lỗi xảy ra:</p>
            <ul class="text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Add/Edit Form -->
    <div id="form-container" class="hidden">
        <div class="bg-white rounded-xl p-8 border border-slate-100 shadow-sm mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-900" id="form-title">Thêm thành viên mới</h3>
                <button type="button" onclick="hideAddForm()" class="text-slate-400 hover:text-slate-600 text-2xl">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <form action="{{ isset($member) ? route('room-member.update', $member->id) : route('room-member.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($member))
                @method('PUT')
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Họ tên -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide flex items-center">
                            <i class="fa fa-user text-teal-600 mr-2.5"></i>Họ và tên
                        </label>
                        <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" required
                            placeholder="Nhập họ và tên"
                            class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-100 outline-none transition placeholder-slate-400 text-slate-800">
                        @error('name')
                        <p class="text-red-500 text-xs mt-2 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Số CCCD -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide flex items-center">
                            <i class="fa fa-id-card text-teal-600 mr-2.5"></i>Số CCCD
                        </label>
                        <input type="text" name="id_card" value="{{ old('id_card', $member->id_card ?? '') }}" required
                            placeholder="Nhập số CCCD"
                            class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-100 outline-none transition placeholder-slate-400 text-slate-800">
                        @error('id_card')
                        <p class="text-red-500 text-xs mt-2 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide flex items-center">
                            <i class="fa fa-phone text-teal-600 mr-2.5"></i>Số điện thoại
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone', $member->phone ?? '') }}" required
                            placeholder="Nhập số điện thoại"
                            class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-100 outline-none transition placeholder-slate-400 text-slate-800">
                        @error('phone')
                        <p class="text-red-500 text-xs mt-2 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CCCD Images -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 pb-8 border-b border-slate-100">
                    <!-- Ảnh mặt trước -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide flex items-center">
                            <i class="fa fa-image text-teal-600 mr-2.5"></i>Ảnh CCCD mặt trước
                        </label>
                        <div class="relative">
                            <input type="file" id="id_card_front" name="id_card_front" accept="image/*"
                                class="hidden" onchange="previewImage(event, 'front-preview')"
                                {{ !isset($member) ? 'required' : '' }}>
                            <label for="id_card_front" class="block w-full px-5 py-8 border-2 border-dashed border-slate-300 rounded-lg cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition text-center">
                                <div id="front-preview-container">
                                    @if (isset($member) && $member->id_card_front)
                                    <img id="front-preview" src="{{ asset($member->id_card_front) }}" alt="Front" class="max-h-32 mx-auto rounded-lg mb-3">
                                    <p class="text-xs text-slate-500">Nhấp để thay đổi</p>
                                    @else
                                    <i class="fa fa-image text-3xl text-slate-300 mb-2"></i>
                                    <p class="text-slate-600 font-medium">Kéo thả hoặc nhấp để chọn</p>
                                    <p class="text-xs text-slate-400 mt-1">JPEG, PNG, GIF • Max 2MB</p>
                                    @endif
                                </div>
                                <img id="front-preview" class="hidden max-h-32 mx-auto rounded-lg">
                            </label>
                        </div>
                        @error('id_card_front')
                        <p class="text-red-500 text-xs mt-2 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ảnh mặt sau -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide flex items-center">
                            <i class="fa fa-image text-teal-600 mr-2.5"></i>Ảnh CCCD mặt sau
                        </label>
                        <div class="relative">
                            <input type="file" id="id_card_back" name="id_card_back" accept="image/*"
                                class="hidden" onchange="previewImage(event, 'back-preview')"
                                {{ !isset($member) ? 'required' : '' }}>
                            <label for="id_card_back" class="block w-full px-5 py-8 border-2 border-dashed border-slate-300 rounded-lg cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition text-center">
                                <div id="back-preview-container">
                                    @if (isset($member) && $member->id_card_back)
                                    <img id="back-preview" src="{{ asset($member->id_card_back) }}" alt="Back" class="max-h-32 mx-auto rounded-lg mb-3">
                                    <p class="text-xs text-slate-500">Nhấp để thay đổi</p>
                                    @else
                                    <i class="fa fa-image text-3xl text-slate-300 mb-2"></i>
                                    <p class="text-slate-600 font-medium">Kéo thả hoặc nhấp để chọn</p>
                                    <p class="text-xs text-slate-400 mt-1">JPEG, PNG, GIF • Max 2MB</p>
                                    @endif
                                </div>
                                <img id="back-preview" class="hidden max-h-32 mx-auto rounded-lg">
                            </label>
                        </div>
                        @error('id_card_back')
                        <p class="text-red-500 text-xs mt-2 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold px-8 py-4 rounded-lg shadow-md shadow-teal-500/30 hover:shadow-lg hover:shadow-teal-500/40 hover:from-teal-600 hover:to-teal-700 active:scale-95 transition">
                        <i class="fa fa-save mr-2"></i>{{ isset($member) ? 'Cập nhật' : 'Thêm' }} thành viên
                    </button>
                    <button type="button" onclick="hideAddForm()" class="flex-1 bg-slate-100 text-slate-700 font-bold px-8 py-4 rounded-lg hover:bg-slate-200 active:scale-95 transition">
                        <i class="fa fa-times mr-2"></i>Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Members List -->
    @if ($members->isEmpty())
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
        <i class="fa fa-info-circle text-blue-600 text-4xl mb-3"></i>
        <p class="text-blue-800 font-bold">Chưa có thành viên ở cùng</p>
        <p class="text-blue-600 text-sm mt-2">Nhấp nút "Thêm thành viên" để bắt đầu</p>
    </div>
    @else
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Họ tên</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Số CCCD</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Điện thoại</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">CCCD</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Trạng thái</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wide">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">{{ $member->name }}</p>
                            <p class="text-xs text-slate-500">Thêm: {{ $member->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">{{ $member->id_card }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $member->phone }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if ($member->id_card_front)
                                <a href="{{ asset($member->id_card_front) }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-200 transition">
                                    <i class="fa fa-image"></i> Trước
                                </a>
                                @endif
                                @if ($member->id_card_back)
                                <a href="{{ asset($member->id_card_back) }}" target="_blank" class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-xs font-bold hover:bg-purple-200 transition">
                                    <i class="fa fa-image"></i> Sau
                                </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($member->is_registered)
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-bold">
                                <i class="fa fa-check mr-1"></i>Đã khai báo
                            </span>
                            @else
                            <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-xs font-bold">
                                <i class="fa fa-clock mr-1"></i>Chưa khai báo
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('room-member.edit', $member->id) }}" class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition">
                                    <i class="fa fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('room-member.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa thành viên này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                        <i class="fa fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</main>

<script>
    window.LaravelData = {
        isEditMode: {{ isset($member) ? 'true' : 'false' }},
        hasErrors: {{ $errors->any() ? 'true' : 'false' }},
        formTitleEdit: 'Chỉnh sửa thông tin',
        formTitleAdd: 'Thêm thành viên mới'
    };
</script>

@endsection