@extends('layouts.admin')

@section('title', 'Danh sách Người thuê')

@section('content')
<main class="flex-1 p-8">
    <h3 class="text-xl font-bold mb-6">Danh sách Người thuê</h3>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <table class="w-full text-left">
            <thead class="text-sm text-gray-500 border-b">
                <tr>
                    <th class="py-3 px-4">Tên</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Điện thoại</th>
                    <th class="py-3 px-4">Số hợp đồng</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $t)
                <tr class="border-b">
                    <td class="py-4 px-4 font-semibold">{{ $t->name }}</td>
                    <td class="py-4 px-4">{{ $t->email }}</td>
                    <td class="py-4 px-4">{{ $t->phone }}</td>
                    <td class="py-4 px-4">{{ $t->contracts->count() }}</td>
                    <td class="py-4 px-4">
                        <a href="#" class="text-blue-400">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $tenants->links() }}
        </div>
    </div>
</main>
@endsection