@extends('layouts.admin')

@section('title', 'Dịch vụ theo phòng')

@section('content')
<main class="flex-1 p-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-black text-gray-700">Dịch vụ theo phòng</h3>
        <a href="{{ route('services.rooms.create') }}" class="btn-primary">Thêm dịch vụ phòng</a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-md">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-container bg-white shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b uppercase text-xs font-black text-slate-400">
                        <th class="p-4">Tên dịch vụ</th>
                        <th class="p-4">Đơn vị</th>
                        <th class="p-4">Phòng</th>
                        <th class="p-4 text-right">Giá</th>
                        <th class="p-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @forelse($services as $s)
                    <tr>
                        <td class="p-4 font-bold">{{ $s->name }}</td>
                        <td class="p-4">{{ $s->unit }}</td>
                        <td class="p-4">{{ optional($s->room)->room_number ?? '—' }}</td>
                        <td class="p-4 text-right">{{ number_format($s->price_per_unit,0,',','.') }}đ</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('services.rooms.edit', $s->id) }}" class="action-btn"><i class="fa fa-pen"></i></a>
                                <form action="{{ route('services.rooms.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Xóa dịch vụ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn text-red-500"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400">Chưa có dịch vụ nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $services->links() }}</div>
</main>
@endsection