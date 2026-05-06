@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="table-container">
            <h3 class="mb-4">Danh sách Bệnh nhân</h3>
            <table class="table">
                <thead>
                <tr><th>Tên bệnh nhân</th><th>Email</th><th>Ngày đăng ký</th><th>Hành động</th></tr>
                </thead>
                <tbody>
                @foreach($patients as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td><button class="btn btn-action btn-primary">Hồ sơ bệnh án</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
