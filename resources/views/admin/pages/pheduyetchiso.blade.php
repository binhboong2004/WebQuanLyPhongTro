@extends('layouts.admin')

@section('title', 'Phê duyệt chỉ số')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Phê duyệt chỉ số</h3>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <table class="w-full text-left">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Ngày</th>
                    <th class="py-3 px-4">Phòng / Tòa</th>
                    <th class="py-3 px-4">Chỉ số điện</th>
                    <th class="py-3 px-4">Chỉ số nước</th>
                    <th class="py-3 px-4">Người ghi</th>
                    <th class="py-3 px-4">Trạng thái</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($readings as $r)
                <tr class="border-b">
                    <td class="py-4 px-4">{{ $r->reading_date }}</td>
                    <td class="py-4 px-4">{{ optional($r->room)->room_number }}{{ optional($r->room->building)->name ? ' / ' . optional($r->room->building)->name : '' }}</td>
                    <td class="py-4 px-4">{{ $r->electricity_index }} (cũ: {{ $r->old_electricity_index }})</td>
                    <td class="py-4 px-4">{{ $r->water_index }} (cũ: {{ $r->old_water_index }})</td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            @if($r->image_proof_elec)
                            <div class="relative group cursor-pointer" onclick="openPreview('{{ asset($r->image_proof_elec) }}')">
                                <img src="{{ asset($r->image_proof_elec) }}" class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                            </div>
                            @endif

                            @if($r->image_proof_water)
                            <div class="relative group cursor-pointer" onclick="openPreview('{{ asset($r->image_proof_water) }}')">
                                <img src="{{ asset($r->image_proof_water) }}" class="w-10 h-10 object-cover rounded border shadow-sm group-hover:brightness-75 transition">
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4">{{ optional($r->creator)->name }}</td>
                    @php
                    $statusLabels = [
                    'approved' => 'Đã duyệt',
                    'pending' => 'Chờ duyệt',
                    'rejected' => 'Bị từ chối',
                    ];
                    $statusLabel = $statusLabels[$r->status] ?? ucfirst($r->status);
                    @endphp
                    <td class="py-4 px-4">{{ $statusLabel }}</td>
                    <td class="py-4 px-4">
                        @if($r->status !== 'approved')
                        <form id="approve-form-{{ $r->id }}" action="{{ route('finance.readings.approve', $r->id) }}" method="POST" style="display:inline">
                            @csrf
                            <input type="hidden" name="admin_note" value="">
                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-lg" onclick="return confirm('Xác nhận phê duyệt?')">Duyệt</button>
                        </form>

                        <form id="reject-form-{{ $r->id }}" action="{{ route('finance.readings.reject', $r->id) }}" method="POST" style="display:inline">
                            @csrf
                            <input type="hidden" name="admin_note" value="">
                        </form>

                        <button type="button" onclick="rejectAction('{{ $r->id }}')" class="px-3 py-1 bg-white text-red-500 border border-red-100 rounded-lg ml-2">Từ chối</button>
                        @else
                        <span class="text-green-600">Đã duyệt</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $readings->links() }}
        </div>
    </div>
</main>
<script src="{{ asset('js/admin/finance-actions.js') }}"></script>
@endsection