@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="table-container">
            <h3 class="mb-4">Tất cả tài khoản</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th><th>Tên</th><th>Email</th><th>Vai trò</th><th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>#{{ $u->id }}</td>
                        <td><strong>{{ $u->name }}</strong></td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge bg-secondary">{{ strtoupper($u->role) }}</span></td>
                        <td>
                            <button class="btn btn-action btn-warning">Sửa</button>
                            <button class="btn btn-action btn-danger">Xóa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
