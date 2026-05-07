@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản lý Bác Sĩ</h2>
        <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
            <i class="fa-solid fa-plus me-2"></i> Thêm Bác Sĩ
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="background-color: var(--sidebar-bg); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-borderless mb-0" style="color: var(--text-light);">
                <thead style="background-color: rgba(0,0,0,0.2); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">ID</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">BÁC SĨ</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">SĐT / EMAIL</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">CHUYÊN KHOA</th>
                    <th class="py-3 px-4 text-muted" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">NƠI LÀM VIỆC</th>
                    <th class="py-3 px-4 text-muted text-center" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">TRẠNG THÁI</th>
                    <th class="py-3 px-4 text-muted text-end" style="font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">HÀNH ĐỘNG</th>
                </tr>
                </thead>

                <tbody>
                @foreach($doctors as $d)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.3s;" onmouseover="this.style.backgroundColor='var(--active-bg)'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="py-3 px-4 align-middle text-muted">#{{ $d->id }}</td>

                        <td class="py-3 px-4 align-middle">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; font-weight: bold; font-size: 0.85rem;">
                                    {{ substr($d->full_name, 0, 2) }}
                                </div>
                                <div>
                                    <span class="fw-bold d-block">{{ $d->full_name }}</span>
                                    <small class="text-muted">{{ $d->qualifications ?? 'Chưa cập nhật bằng cấp' }}</small>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 px-4 align-middle" style="color: var(--text-muted);">
                            <div class="d-block">{{ $d->phone_number ?? 'N/A' }}</div>
                            <small class="text-info">{{ $d->user->email ?? 'N/A' }}</small>
                        </td>

                        <td class="py-3 px-4 align-middle text-lighted">
                            <span class="badge bg-primary px-2 py-1 rounded-pill">{{ $d->specialization->name ?? 'Chưa rõ' }}</span>
                        </td>

                        <td class="py-3 px-4 align-middle text-lighted">
                            {{ $d->city->name ?? 'Chưa phân công' }}
                        </td>
                        <td class="py-3 px-4 align-middle text-end d-flex justify-content-end">
                            <a href="{{ route('admin.doctos.edit', $d->id) }}" class="btn btn-sm btn-outline-info me-2 rounded-circle" style="width: 32px; height: 32px;" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{route('admin.doctos.delete',$d->id)}}" method="POST" onsubmit="return confirm('Xóa hồ sơ bác sĩ này?');">
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

    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <div class="modal-content" style="background-color: var(--sidebar-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title fw-bold" id="addDoctorModalLabel">Thêm Hồ Sơ Bác Sĩ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.doctors.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row g-3">
                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-0">1. Thông tin tài khoản đăng nhập</h6>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Email</label>
                            <input type="email" name="email" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                        </div>

                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Thông tin chuyên môn</h6>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Họ và Tên Bác sĩ</label>
                            <input type="text" name="full_name" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Số điện thoại</label>
                            <input type="text" name="phone_number" class="form-control custom-input text-white" placeholder="SDT">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Chuyên khoa</label>
                            <select name="specialization_id" class="form-select" required style="background: transparent; color: white; border-color: var(--border-color);">
                                <option value="" style="color: black;">-- Chọn chuyên khoa --</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" style="color: black;">{{ $spec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-lighted">Khu vực / Chi nhánh</label>
                            <select name="city_id" class="form-select" required style="background: transparent; color: white; border-color: var(--border-color);">
                                <option value="" style="color: black;">-- Chọn thành phố --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" style="color: black;">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label text-lighted">Bằng cấp / Trình độ</label>
                            <input type="text" name="qualifications" class="form-control custom-input text-white" placeholder="VD: Thạc sĩ, Bác sĩ CKI...">
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label text-lighted">Mô tả / Kinh nghiệm</label>
                            <textarea name="description" class="form-control custom-input text-white" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu Hồ Sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
