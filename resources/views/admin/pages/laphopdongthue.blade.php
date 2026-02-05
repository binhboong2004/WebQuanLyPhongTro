@extends('layouts.admin')

@section('title', 'Lập hợp đồng thuê')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Lập hợp đồng thuê</h3>

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

    <form action="{{ route('contracts.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Người thuê</label>
                <select name="tenant_id" class="w-full border p-2 rounded-xl @error('tenant_id') border-red-500 @enderror">
                    <option value="">-- Chọn người thuê --</option>
                    @foreach($tenants as $t)
                    <option value="{{ $t->id }}">{{ $t->name }} - {{ $t->email }}</option>
                    @endforeach
                </select>
                @error('tenant_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Phòng</label>
                <select name="room_id" class="w-full border p-2 rounded-xl @error('room_id') border-red-500 @enderror">
                    <option value="">-- Chọn phòng --</option>
                    @foreach($rooms as $r)
                    <option value="{{ $r->id }}">{{ optional($r->building)->name ? optional($r->building)->name . ' / ' : '' }}{{ $r->room_number }}</option>
                    @endforeach
                </select>
                @error('room_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Ngày bắt đầu</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border p-2 rounded-xl @error('start_date') border-red-500 @enderror">
                @error('start_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Ngày kết thúc</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border p-2 rounded-xl @error('end_date') border-red-500 @enderror">
                @error('end_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Đặt cọc</label>
                <input type="number" name="deposit" value="{{ old('deposit') }}" class="w-full border p-2 rounded-xl">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Loại hợp đồng</label>
                <input type="text" name="contract_type" value="{{ old('contract_type') }}" class="w-full border p-2 rounded-xl">
            </div>

            <div class="md:col-span-2">
                <button class="btn-primary">LẬP HỢP ĐỒNG</button>
                <a href="{{ route('contracts.index') }}" class="ml-4 text-xs font-bold text-gray-400 uppercase">Hủy</a>
            </div>
        </div>
    </form>
</main>
@endsection