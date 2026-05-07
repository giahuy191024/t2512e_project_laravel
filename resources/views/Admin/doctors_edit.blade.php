@extends('layouts.admin')

@section('content')
    <div class="container mt-4" style="max-width: 800px;">
        <h3 class="fw-bold mb-4">Chỉnh Sửa Bác Sĩ: {{ $doctorEdit->full_name }}</h3>

        @if ($errors->any())
            <div class="alert alert-danger">Vui lòng kiểm tra lại thông tin.</div>
        @endif

        <div class="card p-4 shadow-sm" style="background-color: var(--sidebar-bg); border-color: var(--border-color);">
            <form action="{{ route('admin.doctos.update', $doctorEdit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-0">1. Thông tin tài khoản</h6>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Email đăng nhập</label>
                        <input type="email" name="email" value="{{ $doctorEdit->user->email ?? '' }}" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Mật khẩu mới (Bỏ trống nếu không đổi)</label>
                        <input type="password" name="password" class="form-control" style="background: transparent; color: white; border-color: var(--border-color);">
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label text-muted">Trạng thái hoạt động</label>
                        <select name="status" class="form-select" style="background: transparent; color: white; border-color: var(--border-color);">
                            <option value="active" {{ ($doctorEdit->user->status ?? '') == 'active' ? 'selected' : '' }} style="color: black;">Đang làm việc</option>
                            <option value="inactive" {{ ($doctorEdit->user->status ?? '') == 'inactive' ? 'selected' : '' }} style="color: black;">Đã nghỉ việc / Khóa</option>
                        </select>
                    </div>

                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Thông tin chuyên môn</h6>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Họ và Tên Bác sĩ</label>
                        <input type="text" name="full_name" value="{{ $doctorEdit->full_name }}" class="form-control" required style="background: transparent; color: white; border-color: var(--border-color);">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Số điện thoại</label>
                        <input type="text" name="phone_number" value="{{ $doctorEdit->phone_number }}" class="form-control" style="background: transparent; color: white; border-color: var(--border-color);">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Chuyên khoa</label>
                        <select name="specialization_id" class="form-select" style="background: transparent; color: white; border-color: var(--border-color);">
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}" {{ $doctorEdit->specialization_id == $spec->id ? 'selected' : '' }} style="color: black;">
                                    {{ $spec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label text-muted">Khu vực / Chi nhánh</label>
                        <select name="city_id" class="form-select" style="background: transparent; color: white; border-color: var(--border-color);">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $doctorEdit->city_id == $city->id ? 'selected' : '' }} style="color: black;">
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-2">
                        <label class="form-label text-muted">Bằng cấp / Trình độ</label>
                        <input type="text" name="qualifications" value="{{ $doctorEdit->qualifications }}" class="form-control" style="background: transparent; color: white; border-color: var(--border-color);">
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label text-muted">Mô tả / Kinh nghiệm</label>
                        <textarea name="description" class="form-control" rows="4" style="background: transparent; color: white; border-color: var(--border-color);">{{ $doctorEdit->description }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-info text-white w-100 py-2">Cập Nhật Hồ Sơ</button>
                <a href="{{ route('admin.doctors') }}" class="btn btn-outline-secondary w-100 py-2 mt-2">Hủy bỏ</a>
            </form>
        </div>
    </div>
@endsection
