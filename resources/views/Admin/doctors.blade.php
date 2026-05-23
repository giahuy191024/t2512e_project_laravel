@extends('layouts.admin')
@section('title', 'Quản lý Bác Sĩ')

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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Có lỗi xảy ra, vui lòng kiểm tra lại.</div>
    @endif

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-chip chip-all {{ !request('specialization_id') && !request('city_id') ? 'active' : '' }}" onclick="filterByCategory('', '')">
            <div>
                <div class="label"><i class="fas fa-users"></i> Tất cả</div>
                <div class="value">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="stat-chip chip-specialization {{ request('specialization_id') && !request('city_id') ? 'active' : '' }}">
            <div>
                <div class="label"><i class="fas fa-stethoscope"></i> Theo chuyên khoa</div>
                <div class="value">{{ $specializations->count() }}</div>
            </div>
        </div>
        <div class="stat-chip chip-city {{ request('city_id') && !request('specialization_id') ? 'active' : '' }}">
            <div>
                <div class="label"><i class="fas fa-map-marker-alt"></i> Theo thành phố</div>
                <div class="value">{{ $cities->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.doctors') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Tìm kiếm</label>
                    <input type="text" name="search" class="filter-input" placeholder="Tên bác sĩ, email, hoặc SĐT..." value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-stethoscope"></i> Chuyên khoa</label>
                    <select name="specialization_id" class="filter-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ request('specialization_id') == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-map-marker-alt"></i> Thành phố</label>
                    <select name="city_id" class="filter-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group" style="flex:0;">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Lọc</button>
                </div>
                <div class="filter-group" style="flex:0;">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.doctors') }}" class="btn-reset"><i class="fas fa-redo"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1">
                <i class="fas fa-user-doctor"></i> Danh sách Bác Sĩ
                <span class="result-badge">{{ $doctors->count() }} kết quả</span>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDoctorModal">
                    <i class="fas fa-plus"></i> Thêm Bác Sĩ
                </button>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>BÁC SĨ</th>
                    <th>SĐT / EMAIL</th>
                    <th>CHUYÊN KHOA</th>
                    <th>NƠI LÀM VIỆC</th>
                    <th class="text-right">HÀNH ĐỘNG</th>
                </tr>
                </thead>
                <tbody>
                @foreach($doctors as $d)
                    <tr>
                        <td class="align-middle">#{{ $d->id }}</td>
                        <td class="align-middle">
                            <span class="font-weight-bold d-block">{{ $d->full_name }}</span>
                            <small class="text-muted">{{ $d->qualifications ?? 'Chưa cập nhật bằng cấp' }}</small>
                        </td>
                        <td class="align-middle">
                            <span class="d-block">{{ $d->phone_number ?? 'N/A' }}</span>
                            <small class="text-info">{{ $d->user->email ?? 'N/A' }}</small>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-primary">{{ $d->specialization->name ?? 'Chưa rõ' }}</span>
                        </td>
                        <td class="align-middle">{{ $d->city->name ?? 'Chưa phân công' }}</td>

                        <td class="text-right align-middle">
                            <a href="{{ route('admin.doctors.edit', $d->id) }}" class="btn btn-sm btn-info" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.doctors.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa hồ sơ bác sĩ này?');">
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

    <div class="modal fade" id="addDoctorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Thêm Hồ Sơ Bác Sĩ</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.doctors.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-12"><h5 class="text-primary border-bottom pb-2 mb-3">1. Thông tin tài khoản</h5></div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-12"><h5 class="text-primary border-bottom pb-2 mb-3 mt-3">2. Thông tin chuyên môn</h5></div>
                        <div class="form-group col-md-6">
                            <label>Họ và Tên</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chuyên khoa</label>
                            <select name="specialization_id" class="form-control" required>
                                <option value="">-- Chọn --</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chi nhánh</label>
                            <select name="city_id" class="form-control" required>
                                <option value="">-- Chọn --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Bằng cấp</label>
                            <input type="text" name="qualifications" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Mô tả / Kinh nghiệm</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu Hồ Sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function filterByCategory(specializationId, cityId) {
    const url = new URL(window.location.href);
    
    // Clear previous filters
    url.searchParams.delete('specialization_id');
    url.searchParams.delete('city_id');
    
    // Apply new filters if not empty
    if (specializationId) {
        url.searchParams.set('specialization_id', specializationId);
    }
    if (cityId) {
        url.searchParams.set('city_id', cityId);
    }
    
    window.location.href = url.toString();
}
</script>
@endpush
