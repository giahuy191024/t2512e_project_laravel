@extends('layouts.admin')
@section('title', 'Chỉnh Sửa Bác Sĩ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi dữ liệu!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh Sửa Bác Sĩ: <strong>{{ $doctorEdit->full_name }}</strong></h3>
                </div>

                <form action="{{ route('admin.doctors.update', $doctorEdit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body row">
                        <div class="col-md-12">
                            <h5 class="text-info border-bottom pb-2 mb-3 mt-0">1. Thông tin tài khoản</h5>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Email đăng nhập</label>
                            <input type="email" name="email" value="{{ $doctorEdit->user->email ?? '' }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Bỏ trống nếu không đổi">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                        </div>

                        <div class="col-md-12 mt-3">
                            <h5 class="text-info border-bottom pb-2 mb-3">2. Thông tin chuyên môn</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Họ và Tên Bác sĩ</label>
                            <input type="text" name="full_name" value="{{ $doctorEdit->full_name }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone_number" value="{{ $doctorEdit->phone_number }}" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Chuyên khoa</label>
                            <select name="specialization_id" class="form-control">
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" {{ $doctorEdit->specialization_id == $spec->id ? 'selected' : '' }}>
                                        {{ $spec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Khu vực / Chi nhánh</label>
                            <select name="city_id" class="form-control">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $doctorEdit->city_id == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Bằng cấp / Trình độ</label>
                            <input type="text" name="qualifications" value="{{ $doctorEdit->qualifications }}" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Mô tả / Kinh nghiệm</label>
                            <textarea name="description" class="form-control" rows="4">{{ $doctorEdit->description }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.doctors') }}" class="btn btn-default mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-info">Cập Nhật Hồ Sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
