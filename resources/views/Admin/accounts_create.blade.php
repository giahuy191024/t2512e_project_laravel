@extends('layouts.admin')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="fw-bold mb-4">Thêm Tài Khoản Mới</h3>

    <!-- Hiện lỗi nếu có -->
    @if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra lại thông tin.</div>
    @endif

    <div class="card p-4 shadow-sm" style="background-color: var(--sidebar-bg); border-color: var(--border-color);">
        <form action="{{ route('admin.accounts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted">Họ và Tên</label>
                <input type="text" name="name" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Email</label>
                <input type="email" name="email" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
            </div>

            <div class="mb-4">
                <label class="form-label text-muted">Phân quyền (Role)</label>
                <select name="role" class="form-select" style="background: transparent; color: white; border-color: var(--border-color);">
                    <option value="patient" style="color: black;">Bệnh nhân</option>
                    <option value="doctor" style="color: black;">Bác sĩ</option>
                    <option value="admin" style="color: black;">Quản trị viên</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Lưu Tài Khoản</button>
            <a href="{{ route('admin.accounts') }}" class="btn btn-outline-secondary w-100 py-2 mt-2">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection
