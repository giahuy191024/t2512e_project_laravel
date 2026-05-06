@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Danh sách Bác sĩ</h3>
                <button class="btn btn-primary">+ Thêm Bác sĩ</button>
            </div>
            <table class="table">
                <thead>
                <tr><th>Bác sĩ</th><th>Email</th><th>Chuyên khoa</th><th>Hành động</th></tr>
                </thead>
                <tbody>
                @foreach($doctors as $d)
                    <tr>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->email }}</td>
                        <td><span class="text-muted">Đang cập nhật</span></td>
                        <td>
                            <button class="btn btn-action btn-info text-white">Lịch khám</button>
                            <button class="btn btn-action btn-danger">Xóa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
