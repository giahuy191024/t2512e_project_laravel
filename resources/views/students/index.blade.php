@extends('layouts.app')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách sản phẩm</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm mới</a>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
        <tr class="border-b">
            <th class="py-2">Tên</th>
            <th class="py-2">Giá</th>
            <th class="py-2">Kho</th>
            <th class="py-2">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr class="border-b">
                <td class="py-2">{{ $item->fullName }}</td>
                <td class="py-2">{{$item->email}}đ</td>
                <td class="py-2">{{ $item->phone }}</td>
                <td class="py-2 flex gap-2">
                    <a href="{{ route('students.edit', $item->id) }}" class="text-yellow-600">Sửa</a>
                    <form action="{{ route('students.destroy', $item->id) }}" method="POST"
                          onsubmit="return confirm('Xóa?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
