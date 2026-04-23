@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Thêm sản phẩm</h1>
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="name" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="number" name="price" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="stock" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Mô tả</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Lưu sản phẩm</button>
    </form>
@endsection
