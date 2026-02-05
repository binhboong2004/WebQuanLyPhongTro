@extends('layouts.admin')

@section('title', 'Chỉnh sửa phòng')

@section('content')
<main class="flex-1 p-8">
    <h2 class="text-xl font-bold mb-6">Chỉnh sửa phòng: {{ $room->room_number }}</h2>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tòa nhà</label>
                <select name="building_id" class="search-input w-full border p-2 rounded-xl">
                    @foreach($buildings as $b)
                    <option value="{{ $b->id }}" {{ $room->building_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Số phòng</label>
                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Giá cơ bản</label>
                <input type="text" name="price_base" value="{{ old('price_base', $room->price_base) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Trạng thái</label>
                <select name="status" class="search-input w-full border p-2 rounded-xl">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Trống</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Đang thuê</option>
                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="btn-primary">CẬP NHẬT PHÒNG</button>
                <a href="{{ route('rooms.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase hover:text-gray-600">Hủy</a>
            </div>
        </div>
    </form>
</main>
@endsection