@extends('layouts.doctordashboard')
@section('title', 'Trang chủ Bác sĩ')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2 class="font-weight-bold">Xin chào, {{ auth()->user()->full_name }} 👋</h2>
            <p class="text-muted">Hôm nay là {{ now()->format('l, d/m/Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng lịch khám</span>
                    <span class="info-box-number">{{ $stats['total'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chờ xác nhận</span>
                    <span class="info-box-number">{{ $stats['pending'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-calendar-day"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hôm nay</span>
                    <span class="info-box-number">{{ $stats['today'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check-double"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Đã hoàn thành</span>
                    <span class="info-box-number">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-day"></i> Lịch khám hôm nay</h3>
        </div>
        <div class="card-body p-0">
            @if($todayBookings->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                    Không có lịch khám nào hôm nay
                </div>
            @else
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>Bệnh nhân</th>
                        <th>Email</th>
                        <th>Giờ khám</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($todayBookings as $bk)
                        <tr>
                            <td>{{ $bk->patient->user->full_name ?? '—' }}</td>
                            <td>{{ $bk->patient->user->email ?? '—' }}</td>
                            <td>{{ substr($bk->slot->start_time, 0, 5) }} - {{ substr($bk->slot->end_time, 0, 5) }}</td>
                            <td>
                                @if($bk->status == 0) <span class="badge badge-warning">Chờ xác nhận</span>
                                @elseif($bk->status == 1) <span class="badge badge-info">Đã xác nhận</span>
                                @elseif($bk->status == 2) <span class="badge badge-success">Hoàn thành</span>
                                @else <span class="badge badge-danger">Đã hủy</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
