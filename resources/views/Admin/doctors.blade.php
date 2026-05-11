@extends('layouts.admin')
@section('title', 'Quản lý Bác Sĩ')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Có lỗi xảy ra, vui lòng kiểm tra lại.</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-user-doctor"></i> Danh sách Bác Sĩ</h3>
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
