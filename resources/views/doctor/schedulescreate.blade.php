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
                            <div class="form-group mb-3">
                                <label class="text-muted"><i class="fas fa-calendar-day mr-1"></i> Tuần bắt đầu (chọn 1 ngày thuộc tuần muốn đăng ký)</label>
                                <input type="date" name="week_start" class="form-control" value="{{ old('week_start', $defaultWeekStart ?? date('Y-m-d')) }}">
                                @error('week_start') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted d-block"><i class="fas fa-check-double mr-1"></i> Chọn Thứ trong tuần</label>
                                <div class="d-flex flex-wrap gap-2 bg-light p-3 rounded border">
                                    @php
                                        $days = [1=>'Thứ 2',2=>'Thứ 3',3=>'Thứ 4',4=>'Thứ 5',5=>'Thứ 6',6=>'Thứ 7',7=>'Chủ nhật'];
                                    @endphp
                                    @foreach($days as $k=>$label)
                                        <label class="mr-3"><input type="checkbox" name="week_days[]" value="{{ $k }}"> {{ $label }}</label>
                                    @endforeach
                                </div>
                                @error('week_days') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted d-block"><i class="fas fa-clock mr-1"></i> Chọn ca trong ngày</label>
                                <div class="d-flex gap-3 bg-light p-3 rounded border">
                                    @foreach(\App\Models\DoctorWeekSchedule::defaultSlots() as $code => $label)
                                        <label class="mr-3"><input type="checkbox" name="slots[]" value="{{ $code }}"> {{ $label }}</label>
                                    @endforeach
                                </div>
                                @error('slots') <small class="text-danger">{{ $message }}</small> @enderror
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
