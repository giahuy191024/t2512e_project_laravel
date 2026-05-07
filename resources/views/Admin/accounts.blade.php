@extends('layouts.admin')

@section('content')
    <!-- Tiêu đề và nút Thêm mới -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản lý Tài khoản</h2>
        <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa-solid fa-plus me-2"></i> Thêm tài khoản
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Bảng danh sách -->
    <div class="card" style="background-color: var(--sidebar-bg); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-borderless mb-0" style="color: var(--text-light);">
                <!-- Phần đầu bảng -->
                <thead style="background-color: rgba(0,0,0,0.2); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">ID</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">NGƯỜI DÙNG</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">EMAIL</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">VAI TRÒ</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">NGÀY TẠO</th>
                    <th class="py-3 px-4 text-muted text-end" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">HÀNH ĐỘNG</th>
                </tr>
                </thead>

                <!-- Phần thân bảng (Lặp qua từng user) -->
                <tbody>
                @foreach($users as $u)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.3s;" onmouseover="this.style.backgroundColor='var(--active-bg)'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="py-3 px-4 align-middle text-muted">#{{ $u->id }}</td>

                        <!-- Cột Tên + Avatar -->
                        <td class="py-3 px-4 align-middle">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; font-weight: bold; font-size: 0.85rem;">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span class="fw-bold">{{ $u->name }}</span>
                            </div>
                        </td>

                        <td class="py-3 px-4 align-middle" style="color: var(--text-muted);">{{ $u->email }}</td>

                        <!-- Cột Vai trò (Gắn badge màu tương ứng) -->
                        <td class="py-3 px-4 align-middle">
                            @if($u->role === 'admin')
                                <span class="badge bg-danger px-3 py-2 rounded-pill">Admin</span>
                            @elseif($u->role === 'doctor')
                                <span class="badge bg-success px-3 py-2 rounded-pill">Doctor</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Patient</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 align-middle" style="color: var(--text-muted);">{{ $u->created_at ? $u->created_at->format('d/m/Y') : 'N/A' }}</td>

                        <!-- Cột Nút bấm -->
                            <td class="py-5 px-5 d-flex text-end">
                                <a href="{{ route('admin.accounts.edit', $u->id) }}" class="btn btn-sm btn-outline-info me-2 rounded-circle" style="width: 32px; height: 32px;" title="Chỉnh sửa">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.accounts.delete', $u->id) }}" method="POST" onsubmit="return confirm('Ông có chắc chắn muốn xóa tài khoản này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="Xóa">
                                        <i class="fa-solid fa-trash"></i>
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
