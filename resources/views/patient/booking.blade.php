@extends('layouts.patient')
@section('title', 'Chọn lịch khám')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="https://ui-avatars.com/api/?name={{ urlencode($doctor->full_name) }}&background=0D8ABC&color=fff">
                    </div>
                    <h3 class="profile-username text-center">{{ $doctor->full_name }}</h3>
                    <p class="text-muted text-center">{{ $doctor->specialty }}</p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> Kinh nghiệm</strong>
                    <p class="text-muted">{{ $doctor->experience_years }} năm kinh nghiệm trong ngành y.</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title text-primary"><i class="fas fa-clock mr-2"></i> Lịch khám trống</h3>
                </div>
                <div class="card-body">
                    @if($schedules->isEmpty())
                        <div class="alert alert-warning text-center">
                            Bác sĩ hiện chưa có lịch làm việc được thiết lập. Vui lòng quay lại sau!
                        </div>
                    @else
                        <form action="{{ route('patient.booking.store') }}" method="POST">
                            @csrf
                            @foreach($schedules as $schedule)
                                <div class="schedule-group mb-4">
                                    <h6 class="font-weight-bold text-dark border-left border-info pl-2 mb-3">
                                        Ngày: {{ \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') }}
                                    </h6>
                                    <div class="row g-2">
                                        @foreach($schedule->timeSlots as $slot)
                                            <div class="col-lg-3 col-md-4 col-6 mb-2">
                                                <input type="radio" name="slot_id" id="slot_{{ $slot->id }}" value="{{ $slot->id }}" class="btn-check-custom" required>
                                                <label for="slot_{{ $slot->id }}" class="btn btn-outline-info w-100 py-2">
                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4 border-top pt-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow">
                                    <i class="fas fa-check-circle mr-2"></i> XÁC NHẬN ĐẶT LỊCH
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Ẩn cái nút radio mặc định đi để làm nút bấm cho đẹp */
        .btn-check-custom {
            display: none;
        }
        .btn-check-custom:checked + label {
            background-color: #17a2b8;
            color: white;
            border-color: #17a2b8;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-outline-info {
            transition: all 0.2s ease-in-out;
        }
        .btn-outline-info:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
