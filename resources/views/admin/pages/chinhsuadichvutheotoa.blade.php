@extends('layouts.admin')

@section('title', 'Chỉnh sửa dịch vụ tòa')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Chỉnh sửa dịch vụ: {{ $service->name }}</h3>

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
        <h4 class="font-bold text-red-700 mb-2">Có lỗi xảy ra:</h4>
        <ul class="list-disc list-inside text-red-600 text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('services.buildings.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tên dịch vụ</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="search-input w-full border p-2 rounded-xl @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Đơn vị</label>
                <input type="text" name="unit" value="{{ old('unit', $service->unit) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tòa nhà</label>
                <select name="building_id" class="search-input w-full border p-2 rounded-xl">
                    <option value="">-- Chọn tòa nhà --</option>
                    @foreach($buildings as $b)
                    <option value="{{ $b->id }}" {{ $service->building_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Giá trên đơn vị</label>
                <input type="text" name="price_per_unit" value="{{ old('price_per_unit', $service->price_per_unit) }}" class="search-input w-full border p-2 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <button class="btn-primary">CẬP NHẬT</button>
                <a href="{{ route('services.buildings.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase">Hủy</a>
            </div>
        </div>
    </form>
</main>
@endsection