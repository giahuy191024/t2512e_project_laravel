@extends('layouts.admin')
@section('title', 'Quản lý Tài khoản')

@push('styles')
<style>
/* Unified filter styles for all admin pages */
.filter-card{background:#f8f9fa;border-radius:10px;padding:18px 20px;margin-bottom:22px;box-shadow:0 2px 8px rgba(67,97,238,.04)}
.filter-row{display:flex;gap:14px;flex-wrap:wrap;align-items:end}
.filter-group{flex:1;min-width:180px;display:flex;flex-direction:column}
.filter-group label{font-size:13px;font-weight:700;color:#495057;margin-bottom:6px;letter-spacing:.2px}
.filter-group label i{margin-right:5px;color:#6c757d}
.filter-input,.filter-select{width:100%;padding:9px 13px;border:1.5px solid #d1d5db;border-radius:7px;font-size:14px;background:white;transition:border-color .2s,box-shadow .2s}
.filter-input:focus,.filter-select:focus{outline:none;border-color:#4361ee;box-shadow:0 0 0 2px rgba(67,97,238,.13)}
.btn-filter{padding:9px 22px;border-radius:7px;font-size:14px;font-weight:700;background:#4361ee;color:white;border:none;transition:background .2s}
.btn-filter:hover{background:#2746b6}
.btn-reset{padding:9px 22px;border-radius:7px;font-size:14px;font-weight:700;background:#adb5bd;color:white;text-decoration:none;display:inline-block;transition:background .2s}
.btn-reset:hover{background:#6c757d;color:white}
.stats-row{display:flex;gap:14px;margin-bottom:18px;flex-wrap:wrap}
.stat-chip{flex:1;min-width:150px;background:white;border-radius:10px;padding:15px 18px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;transition:transform .18s,box-shadow .18s;border-left:5px solid #e8ecff;box-shadow:0 2px 8px rgba(67,97,238,.04)}
.stat-chip:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(67,97,238,.10)}
.stat-chip.active{background:#e8ecff}
.stat-chip .label{font-size:12px;font-weight:700;text-transform:uppercase;color:#6c757d;letter-spacing:.5px}
.stat-chip .value{font-size:22px;font-weight:800}
.chip-all{border-left-color:#6c757d}
.chip-admin{border-left-color:#dc3545}
.chip-doctor{border-left-color:#28a745}
.chip-patient{border-left-color:#17a2b8}
.chip-specialization{border-left-color:#17a2b8}
.chip-city{border-left-color:#28a745}
.result-badge{background:#4361ee;color:white;padding:5px 12px;border-radius:20px;font-size:13px;font-weight:600;margin-left:10px}
</style>
@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

    {{-- Stats Row --}}
    <div class="stats-row">
        <div class="stat-chip chip-all {{ !request('role') ? 'active' : '' }}" onclick="filterByRole('')">
            <div>
                <div class="label">Tất cả</div>
                <div class="value">{{ $stats['total'] }}</div>
            </div>
            <i class="fas fa-users" style="font-size:24px;color:#6c757d;opacity:.3"></i>
        </div>
        <div class="stat-chip chip-admin {{ request('role') === 'admin' ? 'active' : '' }}" onclick="filterByRole('admin')">
            <div>
                <div class="label">Admin</div>
                <div class="value">{{ $stats['admin'] }}</div>
            </div>
            <i class="fas fa-user-shield" style="font-size:24px;color:#dc3545;opacity:.3"></i>
        </div>
        <div class="stat-chip chip-doctor {{ request('role') === 'doctor' ? 'active' : '' }}" onclick="filterByRole('doctor')">
            <div>
                <div class="label">Doctor</div>
                <div class="value">{{ $stats['doctor'] }}</div>
            </div>
            <i class="fas fa-user-md" style="font-size:24px;color:#28a745;opacity:.3"></i>
        </div>
        <div class="stat-chip chip-patient {{ request('role') === 'patient' ? 'active' : '' }}" onclick="filterByRole('patient')">
            <div>
                <div class="label">Patient</div>
                <div class="value">{{ $stats['patient'] }}</div>
            </div>
            <i class="fas fa-hospital-user" style="font-size:24px;color:#17a2b8;opacity:.3"></i>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.accounts') }}" id="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Tìm kiếm</label>
                    <input type="text" name="search" class="filter-input" placeholder="Tên hoặc email..." value="{{ request('search') }}">
                </div>
                <div class="filter-group" style="flex:0.5">
                    <label><i class="fas fa-user-tag"></i> Vai trò</label>
                    <select name="role" class="filter-select">
                        <option value="">-- Tất cả --</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="doctor" {{ request('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                    </select>
                </div>
                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn btn-primary btn-filter">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    <a href="{{ route('admin.accounts') }}" class="btn btn-secondary btn-filter">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1">
                <i class="fas fa-list"></i> Danh sách Tài khoản
                <span class="badge badge-secondary ml-2">{{ $users->count() }} kết quả</span>
            </h3>
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

@push('scripts')
<script>
function filterByRole(role) {
    // Get current search value if any
    const searchValue = document.querySelector('input[name="search"]').value;
    
    // Build URL with parameters
    const url = new URL(window.location.href);
    url.searchParams.set('role', role);
    if (searchValue) {
        url.searchParams.set('search', searchValue);
    }
    
    // Redirect to filtered URL
    window.location.href = url.toString();
}
</script>
@endpush
