@extends('layouts.admin')

@section('title', 'Chi tiết Hóa đơn')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Chi tiết Hóa đơn #{{ $invoice->id }}</h3>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Phòng:</strong> {{ optional($invoice->room)->room_number }} {{ optional($invoice->room->building)->name ?: '' }}</p>
                <p><strong>Tháng:</strong> {{ $invoice->month_year }}</p>
                <p><strong>Tổng:</strong> {{ number_format($invoice->total_amount) }}đ</p>
            </div>
            <div>
                @php
                $invStatusLabels = [
                'paid' => 'Đã thanh toán',
                'unpaid' => 'Chưa thanh toán',
                'overdue' => 'Quá hạn',
                ];
                $invStatusLabel = $invStatusLabels[$invoice->status] ?? ucfirst($invoice->status);
                @endphp
                <p><strong>Trạng thái:</strong> {{ $invStatusLabel }}</p>
                <p><strong>Phương thức:</strong> {{ $invoice->payment_method }}</p>
                <p><strong>Ngày thanh toán:</strong> {{ $invoice->payment_date }}</p>
            </div>
        </div>

        <h4 class="mt-6 font-semibold">Chi tiết</h4>
        <table class="w-full text-left mt-2">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Mô tả</th>
                    <th class="py-3 px-4">Số lượng</th>
                    <th class="py-3 px-4">Đơn giá</th>
                    <th class="py-3 px-4">Tổng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->details as $d)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $d->description }}</td>
                    <td class="py-3 px-4">{{ $d->quantity }}</td>
                    <td class="py-3 px-4">{{ number_format($d->unit_price) }}đ</td>
                    <td class="py-3 px-4">{{ number_format($d->subtotal) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection