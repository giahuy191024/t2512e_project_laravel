@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Sửa sản phẩm</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Mô tả</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ $product->description }}</textarea>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật</button>
    </form>
@endsection
