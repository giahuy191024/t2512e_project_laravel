@extends('layouts.patient')
@section('title', 'Tìm kiếm Bác sĩ')

@section('content')
    <div class="row">
        @foreach($doctors as $d)
            <div class="col-md-4">
                <div class="card card-widget widget-user shadow-sm">
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">{{ $d->full_name }}</h3>
                        <h5 class="widget-user-desc">{{ $d->specialization->name ?? 'Chuyên khoa' }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="https://ui-avatars.com/api/?name={{ urlencode($d->full_name) }}&background=random" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 text-center mb-3">
                                <div class="description-block">
                                    <h5 class="description-header"><i class="fas fa-map-marker-alt text-danger"></i> Chi nhánh</h5>
                                    <span class="description-text">{{ $d->city->name ?? 'Chưa rõ' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a href="{{ route('patient.booking', $d->id) }}" class="btn btn-primary btn-block">
                                    <i class="far fa-calendar-alt"></i> Đặt lịch ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
