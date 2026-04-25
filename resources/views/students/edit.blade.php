@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Sửa sản phẩm</h1>
    <form action="{{ route('products.update', $obj->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ $obj->fullName }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="text" name="email" value="{{ $obj->email }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="phone" value="{{ $obj->phone }}" class="w-full border p-2 rounded">
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật</button>
    </form>
@endsection
