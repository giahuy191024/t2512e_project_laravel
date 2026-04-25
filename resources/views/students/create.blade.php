@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Thêm sản phẩm</h1>
    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="fullName" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="email" name="email" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="phone" class="w-full border p-2 rounded">
        </div>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Lưu Sinh Vien</button>
    </form>
@endsection
