@extends('layouts.admin')

@section('title', 'Danh sách đóng tiền')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Danh sách đóng tiền</h3>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <table class="w-full text-left">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Mã</th>
                    <th class="py-3 px-4">Phòng / Tòa</th>
                    <th class="py-3 px-4">Tháng</th>
                    <th class="py-3 px-4">Tổng tiền</th>
                    <th class="py-3 px-4">Trạng thái</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $inv)
                <tr class="border-b">
                    <td class="py-4 px-4">#{{ $inv->id }}</td>
                    <td class="py-4 px-4">{{ optional($inv->room)->room_number }}{{ optional($inv->room->building)->name ? ' / ' . optional($inv->room->building)->name : '' }}</td>
                    <td class="py-4 px-4">{{ $inv->month_year }}</td>
                    <td class="py-4 px-4">{{ number_format($inv->total_amount) }}đ</td>
                    @php
                    $invStatusLabels = [
                    'paid' => 'Đã thanh toán',
                    'unpaid' => 'Chưa thanh toán',
                    'overdue' => 'Quá hạn',
                    ];
                    $invStatusLabel = $invStatusLabels[$inv->status] ?? ucfirst($inv->status);
                    @endphp
                    <td class="py-4 px-4">{{ $invStatusLabel }}</td>
                    <td class="py-4 px-4">
                        <a href="{{ route('finance.invoices.show', $inv->id) }}" class="text-blue-400">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    </div>
</main>
@endsection