@extends('layouts.admin')
@section('title', 'Thêm Tài Khoản')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi dữ liệu!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thêm Tài Khoản Mới</h3>
                </div>

                <form action="{{ route('admin.accounts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Họ và Tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ tên" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label>Phân quyền (Role)</label>
                            <select name="role" class="form-control">
                                <option value="patient">Bệnh nhân</option>
                                <option value="admin">Quản trị viên</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.accounts') }}" class="btn btn-default mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary">Lưu Tài Khoản</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
