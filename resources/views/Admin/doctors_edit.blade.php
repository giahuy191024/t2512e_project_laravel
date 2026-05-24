@extends('layouts.admin')
@section('title', 'Chỉnh Sửa Bác Sĩ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi dữ liệu!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh Sửa Bác Sĩ: <strong>{{ $doctorEdit->full_name }}</strong></h3>
                </div>

                <form action="{{ route('admin.doctors.update', $doctorEdit->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body row">
                        {{-- 1. Tài khoản --}}
                        <div class="col-md-12">
                            <h5 class="text-info border-bottom pb-2 mb-3 mt-0">1. Thông tin tài khoản</h5>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Email đăng nhập</label>
                            <input type="email" name="email" value="{{ old('email', $doctorEdit->user->email ?? '') }}" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Bỏ trống nếu không đổi" minlength="6">
                            <small class="text-muted">Để trống nếu không đổi</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        {{-- 2. Chuyên môn --}}
                        <div class="col-md-12 mt-3">
                            <h5 class="text-info border-bottom pb-2 mb-3">2. Thông tin chuyên môn</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $doctorEdit->full_name) }}" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chuyên khoa <span class="text-danger">*</span></label>
                            <select name="specialty_id" class="form-control" required>
                                <option value="">-- Chọn chuyên khoa --</option>
                                @foreach($specialties as $sp)
                                    <option value="{{ $sp->id }}" {{ old('specialty_id', $doctorEdit->specialty_id) == $sp->id ? 'selected' : '' }}>
                                        {{ $sp->icon }} {{ $sp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Thành phố / Cơ sở <span class="text-danger">*</span></label>
                            <select name="city_id" class="form-control" required>
                                <option value="">-- Chọn --</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c->id }}" {{ old('city_id', $doctorEdit->city_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Số năm kinh nghiệm</label>
                            <input type="number" name="experience_years" value="{{ old('experience_years', $doctorEdit->experience_years) }}" class="form-control" min="0">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $doctorEdit->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $doctorEdit->status == 0 ? 'selected' : '' }}>Tạm nghỉ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Mô tả / Giới thiệu</label>
                            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $doctorEdit->bio) }}</textarea>
                        </div>

                        {{-- 3. Avatar --}}
                        <div class="col-md-12 mt-3">
                            <h5 class="text-info border-bottom pb-2 mb-3">3. Ảnh đại diện</h5>
                        </div>
                        <div class="form-group col-md-12 d-flex align-items-center" style="gap:24px;flex-wrap:wrap">
                            <div>
                                @if($doctorEdit->user?->avatar_url)
                                    <img src="{{ asset('storage/' . $doctorEdit->user->avatar_url) }}"
                                         style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #17a2b8">
                                @else
                                    <div style="width:120px;height:120px;border-radius:50%;background:#e0f4f8;display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:700;color:#17a2b8">
                                        {{ strtoupper(mb_substr($doctorEdit->full_name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div style="flex:1;min-width:280px">
                                <label>Ảnh mới (tùy chọn)</label>
                                <input type="file" name="avatar" class="form-control-file" accept="image/*">
                                <small class="text-muted">JPG, PNG. Tối đa 2MB. Để trống nếu không đổi.</small>
                            </div>
                        </div>

                        {{-- 4. Certificate --}}
                        <div class="col-md-12 mt-3">
                            <h5 class="text-info border-bottom pb-2 mb-3">4. Chứng chỉ hành nghề</h5>
                        </div>
                        <div class="form-group col-md-12">
                            @if($doctorEdit->certificate_url)
                                @php $isPdf = str_ends_with(strtolower($doctorEdit->certificate_url), '.pdf'); @endphp
                                <div style="margin-bottom:16px;padding:14px;border:2px solid #d6eef3;border-radius:10px;display:flex;align-items:center;gap:14px;background:#f5fbfc">
                                    @if($isPdf)
                                        <i class="fas fa-file-pdf" style="font-size:32px;color:#e63946"></i>
                                    @else
                                        <img src="{{ asset('storage/' . $doctorEdit->certificate_url) }}"
                                             style="width:50px;height:50px;object-fit:cover;border-radius:6px">
                                    @endif
                                    <div style="flex:1">
                                        <div style="font-weight:600">Chứng chỉ hiện tại</div>
                                        <small class="text-muted">{{ basename($doctorEdit->certificate_url) }}</small>
                                    </div>
                                    <a href="{{ asset('storage/' . $doctorEdit->certificate_url) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                </div>
                            @else
                                <p class="text-muted"><i class="fas fa-info-circle"></i> Chưa có chứng chỉ nào.</p>
                            @endif
                            <label>Chứng chỉ mới (tùy chọn)</label>
                            <input type="file" name="certificate" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">JPG, PNG, PDF. Tối đa 5MB. Để trống nếu không đổi.</small>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.doctors') }}" class="btn btn-default mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Cập Nhật Hồ Sơ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
