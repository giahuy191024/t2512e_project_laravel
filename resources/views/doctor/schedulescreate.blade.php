@extends('layouts.admin')
@section('title', 'Thiết lập Lịch làm việc')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <form action="{{ route('doctor.schedules.store') }}" method="POST">
                    @csrf
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                <i class="fas fa-calendar-plus mr-2 text-primary"></i> Đăng ký Lịch làm việc
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="text-muted d-block"><i class="fas fa-check-double mr-1"></i> Chọn Thứ:</label>
                                <div class="d-flex flex-wrap justify-content-between bg-light p-3 rounded border">
                                    @php
                                        $days = [
                                            1 => 'Thứ 2', 2 => 'Thứ 3', 3 => 'Thứ 4',
                                            4 => 'Thứ 5', 5 => 'Thứ 6', 6 => 'Thứ 7', 0 => 'Chủ Nhật'
                                        ];
                                    @endphp
                                    @foreach($days as $value => $label)
                                        <div class="custom-control custom-checkbox custom-control-inline mx-2">
                                            <input class="custom-control-input" type="checkbox" name="week_days[]" id="day_{{ $value }}" value="{{ $value }}">
                                            <label for="day_{{ $value }}" class="custom-control-label font-weight-normal">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('week_days') <small class="text-danger font-italic">{{ $message }}</small> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 border-right">
                                    <label class="text-muted"><i class="fas fa-calendar-day mr-1"></i> Giai đoạn áp dụng:</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <small class="text-secondary">Từ ngày</small>
                                                <input type="date" name="start_date" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <small class="text-secondary">Đến ngày</small>
                                                <input type="date" name="end_date" class="form-control shadow-sm" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-muted"><i class="fas fa-clock mr-1"></i> Khung giờ & Thời lượng:</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <small class="text-secondary">Bắt đầu</small>
                                                <div class="input-group shadow-sm">
                                                    <input type="time" name="start_time" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <small class="text-secondary">Kết thúc</small>
                                                <div class="input-group shadow-sm">
                                                    <input type="time" name="end_time" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <small class="text-secondary">Phút/Ca</small>
                                                <select name="slot_duration" class="form-control shadow-sm">
                                                    <option value="30">30p</option>
                                                    <option value="45">45p</option>
                                                    <option value="60">60p</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top-0 py-3">
                            <div class="float-right">
                                <a href="{{ route('doctor.schedules.index') }}" class="btn btn-light border mr-2">
                                    <i class="fas fa-times"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow">
                                    <i class="fas fa-save mr-1"></i> Xác nhận Đăng ký
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="alert alert-info border-0 shadow-sm">
                    <h5><i class="icon fas fa-info-circle"></i> Mẹo nhỏ!</h5>
                    Ông có thể đăng ký nhiều khung giờ cho cùng một tuần. Ví dụ: Đăng ký 2-4-6 làm Sáng, sau đó quay lại đây đăng ký 3-5-7 làm Chiều. Hệ thống sẽ tự động tổng hợp.
                </div>
            </div>
        </div>
    </div>

    <style>
        /* CSS tùy chỉnh thêm cho đẹp */
        .custom-control-label { cursor: pointer; transition: all 0.2s; }
        .custom-control-input:checked ~ .custom-control-label { color: #007bff; font-weight: bold !important; }
        .card { border-radius: 12px; }
        input[type="date"], input[type="time"], select { border-radius: 8px !important; }
        .bg-light { background-color: #f8f9fa !important; }
    </style>
@endsection
