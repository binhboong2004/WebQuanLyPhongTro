@extends('layouts.admin')

@section('title', 'Danh sách Hợp đồng')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Danh sách Hợp đồng</h3>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <table class="w-full text-left">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Mã</th>
                    <th class="py-3 px-4">Người thuê</th>
                    <th class="py-3 px-4">Phòng / Tòa</th>
                    <th class="py-3 px-4">Thời hạn</th>
                    <th class="py-3 px-4">Đặt cọc</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $c)
                <tr class="border-b">
                    <td class="py-4 px-4">#{{ $c->id }}</td>
                    <td class="py-4 px-4 font-semibold">{{ optional($c->tenant)->name }}</td>
                    <td class="py-4 px-4">{{ optional($c->room)->room_number }} {{ optional($c->room->building)->name ? '/ ' . optional($c->room->building)->name : '' }}</td>
                    <td class="py-4 px-4">{{ $c->start_date }} -> {{ $c->end_date ?? 'Không rõ' }}</td>
                    <td class="py-4 px-4">{{ number_format($c->deposit ?? 0) }}đ</td>
                    <td class="py-4 px-4">
                        <a href="#" class="text-blue-400">Chi tiết</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $contracts->links() }}
        </div>
    </div>
</main>
@endsection