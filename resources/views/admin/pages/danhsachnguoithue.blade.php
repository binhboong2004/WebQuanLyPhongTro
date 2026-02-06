@extends('layouts.admin')

@section('title', 'Danh sách Thành viên (Cư dân)')

@section('content')
    <main class="flex-1 p-8">
        <h3 class="text-xl font-bold mb-6">Danh sách Thành viên (Cư dân)</h3>

        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <table class="w-full text-left">
                <thead class="text-sm text-gray-500 border-b">
                    <tr>
                        <th class="py-3 px-4">Họ tên</th>
                        <th class="py-3 px-4">Số CCCD</th>
                        <th class="py-3 px-4">Điện thoại</th>
                        <th class="py-3 px-4">Phòng</th>
                        <th class="py-3 px-4">Ảnh CCCD</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr class="border-b hover:bg-slate-50 transition">
                            <td class="py-4 px-4 font-semibold text-slate-700">{{ $member->name }}</td>
                            <td class="py-4 px-4 text-slate-600">{{ $member->id_card }}</td>
                            <td class="py-4 px-4 text-slate-600">{{ $member->phone }}</td>
                            <td class="py-4 px-4">
                                @if($member->room)
                                    <span class="font-bold text-teal-600">{{ $member->room->room_number }}</span>
                                    <div class="text-xs text-slate-400">{{ $member->room->building->name ?? '' }}</div>
                                @else
                                    <span class="text-slate-400 italic">Chưa gán</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    @if ($member->id_card_front)
                                        <a href="{{ asset($member->id_card_front) }}" target="_blank"
                                            class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100 hover:bg-blue-100 transition">Trước</a>
                                    @endif
                                    @if ($member->id_card_back)
                                        <a href="{{ asset($member->id_card_back) }}" target="_blank"
                                            class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded border border-purple-100 hover:bg-purple-100 transition">Sau</a>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @if ($member->is_registered)
                                    <span
                                        class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold"><i
                                            class="fa fa-check"></i> Đã khai báo</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold"><i
                                            class="fa fa-clock"></i> Chưa khai báo</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <a href="#" class="text-blue-500 hover:text-blue-700 font-medium text-sm">Chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </main>
@endsection