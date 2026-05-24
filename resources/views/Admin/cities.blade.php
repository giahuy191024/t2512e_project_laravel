@extends('layouts.admin')
@section('title', 'Quản lý Thành phố')

@push('styles')
    <style>
        .filter-card{background:#f8f9fa;border-radius:10px;padding:18px 20px;margin-bottom:22px;box-shadow:0 2px 8px rgba(67,97,238,.04)}
        .filter-row{display:flex;gap:14px;flex-wrap:wrap;align-items:end}
        .filter-group{flex:1;min-width:180px;display:flex;flex-direction:column}
        .filter-group label{font-size:13px;font-weight:700;color:#495057;margin-bottom:6px}
        .filter-input,.filter-select{width:100%;padding:9px 13px;border:1.5px solid #d1d5db;border-radius:7px;font-size:14px;background:white}
        .filter-input:focus,.filter-select:focus{outline:none;border-color:#4361ee;box-shadow:0 0 0 2px rgba(67,97,238,.13)}
        .btn-filter{padding:9px 22px;border-radius:7px;font-size:14px;font-weight:700;background:#4361ee;color:white;border:none}
        .stats-row{display:flex;gap:14px;margin-bottom:18px;flex-wrap:wrap}
        .stat-chip{flex:1;min-width:150px;background:white;border-radius:10px;padding:15px 18px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;border-left:5px solid #e8ecff;box-shadow:0 2px 8px rgba(67,97,238,.04);transition:transform .18s}
        .stat-chip:hover{transform:translateY(-2px)}
        .stat-chip.active{background:#e8ecff}
        .stat-chip .label{font-size:12px;font-weight:700;text-transform:uppercase;color:#6c757d}
        .stat-chip .value{font-size:22px;font-weight:800}
        .chip-all{border-left-color:#6c757d}
        .chip-active{border-left-color:#28a745}
        .chip-inactive{border-left-color:#dc3545}
    </style>
@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>Swal.fire({toast:true,position:'top-end',icon:'success',title:"{{ session('success') }}",showConfirmButton:false,timer:3000});</script>
    @endif

    @if(session('error'))
        <script>Swal.fire({toast:true,position:'top-end',icon:'error',title:"{{ session('error') }}",showConfirmButton:false,timer:4000});</script>
    @endif

    {{-- Stats Row --}}
    <div class="stats-row">
        <div class="stat-chip chip-all {{ request('status') === null ? 'active' : '' }}" onclick="filterByStatus('')">
            <div>
                <div class="label">Tất cả</div>
                <div class="value">{{ $stats['total'] }}</div>
            </div>
            <i class="fas fa-city" style="font-size:24px;color:#6c757d;opacity:.3"></i>
        </div>
        <div class="stat-chip chip-active {{ request('status') === '1' ? 'active' : '' }}" onclick="filterByStatus('1')">
            <div>
                <div class="label">Đang hoạt động</div>
                <div class="value">{{ $stats['active'] }}</div>
            </div>
            <i class="fas fa-check-circle" style="font-size:24px;color:#28a745;opacity:.3"></i>
        </div>
        <div class="stat-chip chip-inactive {{ request('status') === '0' ? 'active' : '' }}" onclick="filterByStatus('0')">
            <div>
                <div class="label">Không hoạt động</div>
                <div class="value">{{ $stats['inactive'] }}</div>
            </div>
            <i class="fas fa-times-circle" style="font-size:24px;color:#dc3545;opacity:.3"></i>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.cities') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Tìm kiếm</label>
                    <input type="text" name="search" class="filter-input" placeholder="Tên hoặc mã thành phố..." value="{{ request('search') }}">
                </div>
                <div class="filter-group" style="flex:0.5">
                    <label><i class="fas fa-toggle-on"></i> Trạng thái</label>
                    <select name="status" class="filter-select">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn btn-primary btn-filter"><i class="fas fa-filter"></i> Lọc</button>
                    <a href="{{ route('admin.cities') }}" class="btn btn-secondary btn-filter" style="background:#adb5bd"><i class="fas fa-redo"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1">
                <i class="fas fa-city"></i> Danh sách Thành phố
                <span class="badge badge-secondary ml-2">{{ $cities->count() }} kết quả</span>
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Thêm thành phố
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>TÊN THÀNH PHỐ</th>
                    <th>MÃ CODE</th>
                    <th class="text-center">BÁC SĨ</th>
                    <th class="text-center">SORT</th>
                    <th class="text-center">TRẠNG THÁI</th>
                    <th class="text-right">HÀNH ĐỘNG</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td class="align-middle">#{{ $city->id }}</td>
                        <td class="align-middle"><span class="font-weight-bold">{{ $city->name }}</span></td>
                        <td class="align-middle"><code>{{ $city->code }}</code></td>
                        <td class="align-middle text-center">
                            <span class="badge badge-info">{{ $city->doctors_count }}</span>
                        </td>
                        <td class="align-middle text-center">{{ $city->sort_order }}</td>
                        <td class="align-middle text-center">
                            @if($city->status == 1)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-secondary">Tắt</span>
                            @endif
                        </td>
                        <td class="text-right align-middle">
                            <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-sm btn-info" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.cities.delete', $city->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa thành phố này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa" {{ $city->doctors_count > 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox" style="font-size:32px;opacity:.3"></i><br>
                            Chưa có thành phố nào
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function filterByStatus(status) {
            const url = new URL(window.location.href);
            if (status === '') url.searchParams.delete('status');
            else url.searchParams.set('status', status);
            window.location.href = url.toString();
        }
    </script>
@endpush
