@extends('layouts.admin')
@section('title', 'Quản lý Tài khoản')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Thành công!</h5>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-list"></i> Danh sách Tài khoản</h3>
            <div class="card-tools">
                <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Thêm tài khoản
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>NGƯỜI DÙNG</th>
                    <th>EMAIL</th>
                    <th>VAI TRÒ</th>
                    <th>NGÀY TẠO</th>
                    <th class="text-right">HÀNH ĐỘNG</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $u)
                    <tr>
                        <td class="align-middle">#{{ $u->id }}</td>
                        <td class="align-middle">
                            <span class="font-weight-bold">{{ $u->name }}</span>
                        </td>
                        <td class="align-middle">{{ $u->email }}</td>
                        <td class="align-middle">
                            @if($u->role === 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @elseif($u->role === 'doctor')
                                <span class="badge badge-success">Doctor</span>
                            @else
                                <span class="badge badge-secondary">Patient</span>
                            @endif
                        </td>
                        <td class="align-middle">{{ $u->created_at ? $u->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td class="text-right align-middle">
                            <a href="{{ route('admin.accounts.edit', $u->id) }}" class="btn btn-sm btn-info" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.accounts.delete', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa tài khoản này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
