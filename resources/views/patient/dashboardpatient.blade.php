@extends('layouts.patient')
@section('title', 'Trang chủ Bệnh nhân')

@section('content')
    <div class="row mt-4">
        <div class="col-12 text-center mb-5">
            <h2 class="font-weight-bold">Chào mừng trở lại, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">Ông muốn chúng tôi hỗ trợ gì hôm nay?</p>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-primary card-outline text-center p-4">
                <i class="fas fa-user-md fa-4x text-primary mb-3"></i>
                <h4>Đặt lịch khám</h4>
                <p>Tìm kiếm bác sĩ giỏi và đặt lịch hẹn nhanh chóng.</p>
                <a href="{{route('patient.doctors')}}" class="btn btn-primary rounded-pill">Tìm Bác Sĩ Ngay</a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-success card-outline text-center p-4">
                <i class="fas fa-calendar-check fa-4x text-success mb-3"></i>
                <h4>Quản lý lịch hẹn</h4>
                <p>Xem lại các lịch hẹn sắp tới hoặc lịch sử khám bệnh.</p>
                <a href="" class="btn btn-success rounded-pill">Xem Lịch Hẹn</a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-info card-outline text-center p-4">
                <i class="fas fa-id-card fa-4x text-info mb-3"></i>
                <h4>Hồ sơ cá nhân</h4>
                <p>Cập nhật thông tin cá nhân và tiền sử bệnh lý.</p>
                <a href="" class="btn btn-info rounded-pill text-white">Cập Nhật Hồ Sơ</a>
            </div>
        </div>
    </div>
@endsection
