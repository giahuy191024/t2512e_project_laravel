@extends('layouts.admin')

@section('content')
    <div class="container mt-4" style="max-width: 600px;">
        <h3 class="fw-bold mb-4">Chỉnh Sửa Tài Khoản: {{ $userEdit->name }}</h3>

        <div class="card p-4 shadow-sm" style="background-color: var(--sidebar-bg); border-color: var(--border-color);">
            <!-- Chú ý có @method('PUT') -->
            <form action="{{ route('admin.accounts.update', $userEdit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-muted">Họ và Tên</label>
                    <input type="text" name="name" value="{{ $userEdit->name }}" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <input type="email" name="email" value="{{ $userEdit->email }}" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Mật khẩu mới (Để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" style="background: transparent; color: white; border-color: var(--border-color);">
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Phân quyền (Role)</label>
                    <select name="role" class="form-select" style="background: transparent; color: white; border-color: var(--border-color);">
                        <option value="patient" {{ $userEdit->role == 'patient' ? 'selected' : '' }} style="color: black;">Bệnh nhân</option>
                        <option value="admin" {{ $userEdit->role == 'admin' ? 'selected' : '' }} style="color: black;">Quản trị viên</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-info text-white w-100 py-2">Cập Nhật</button>
                <a href="{{ route('admin.accounts') }}" class="btn btn-outline-secondary w-100 py-2 mt-2">Hủy bỏ</a>
            </form>
        </div>
    </div>
@endsection
