@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
:root {
    --primary: #4361ee;
    --primary-light: #e8ecff;
    --success: #2ec4b6;
    --warning: #f4a100;
    --danger: #e63946;
    --info: #7209b7;
    --text-dark: #1a1a2e;
    --text-muted: #6c757d;
    --shadow: 0 4px 24px rgba(67,97,238,.10);
    --radius: 14px;
}
body { background: #f0f4ff !important; }

.admin-hero {
    background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
    border-radius: var(--radius);
    padding: 32px 36px;
    color: white;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    animation: fadeUp .5s ease both;
}
.admin-hero::before { content:''; position:absolute; width:260px; height:260px; border-radius:50%; background:rgba(255,255,255,.07); top:-80px; right:-40px; }
.admin-hero::after  { content:''; position:absolute; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,.05); bottom:-50px; right:160px; }
.admin-hero h1 { font-size:26px; font-weight:800; margin:0 0 6px; position:relative; z-index:1; }
.admin-hero p  { margin:0; opacity:.85; font-size:14px; position:relative; z-index:1; }
.admin-hero .date-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.2); border-radius:20px; padding:4px 14px; font-size:12px; font-weight:600; margin-bottom:12px; position:relative; z-index:1; }

.stat-card { background:white; border-radius:var(--radius); padding:22px 24px; box-shadow:var(--shadow); display:flex; align-items:center; gap:18px; transition:transform .2s,box-shadow .2s; animation:fadeUp .5s ease both; text-decoration:none; color:inherit; }
.stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 36px rgba(67,97,238,.18); color:inherit; text-decoration:none; }
.stat-icon { width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; }
.stat-body .stat-value { font-size:28px; font-weight:800; color:var(--text-dark); line-height:1; }
.stat-body .stat-label { font-size:12px; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

.booking-stat-row { background:white; border-radius:var(--radius); padding:20px 28px; box-shadow:var(--shadow); display:flex; align-items:center; justify-content:space-around; flex-wrap:wrap; gap:16px; margin-bottom:28px; animation:fadeUp .5s ease .1s both; }
.booking-stat-item { text-align:center; }
.booking-stat-item .bval { font-size:26px; font-weight:800; }
.booking-stat-item .blabel { font-size:11px; text-transform:uppercase; font-weight:600; color:var(--text-muted); letter-spacing:.5px; }
.bval.pending   { color:var(--warning); }
.bval.confirmed { color:var(--primary); }
.bval.done      { color:var(--success); }
.bval.cancelled { color:var(--danger); }
.bval.total     { color:var(--text-dark); }

.section-card { background:white; border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden; animation:fadeUp .5s ease .15s both; }
.section-header { display:flex; align-items:center; justify-content:space-between; padding:18px 24px; border-bottom:1px solid #f0f0f0; }
.section-header h5 { margin:0; font-weight:700; font-size:15px; display:flex; align-items:center; gap:10px; }
.section-header .icon-wrap { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; }
.view-all-btn { font-size:12px; font-weight:600; color:var(--primary); text-decoration:none; background:var(--primary-light); padding:6px 14px; border-radius:20px; transition:all .2s; }
.view-all-btn:hover { background:var(--primary); color:white; }

.booking-table { width:100%; border-collapse:collapse; }
.booking-table th { font-size:11px; text-transform:uppercase; font-weight:700; color:var(--text-muted); letter-spacing:.6px; padding:12px 16px; border-bottom:2px solid #f0f0f0; background:#fafbff; }
.booking-table td { padding:13px 16px; border-bottom:1px solid #f8f8f8; vertical-align:middle; }
.booking-table tr:last-child td { border-bottom:none; }
.booking-table tr:hover td { background:#fafbff; }
.pt-avatar { width:36px; height:36px; border-radius:50%; object-fit:cover; margin-right:10px; }
.pt-name   { font-size:14px; font-weight:600; color:var(--text-dark); }
.pt-email  { font-size:11px; color:var(--text-muted); }

.status-badge { display:inline-flex; align-items:center; gap:5px; border-radius:20px; padding:4px 10px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }
.status-0 { background:#fff8e1; color:#f4a100; }
.status-1 { background:#e8ecff; color:#4361ee; }
.status-2 { background:#e6faf8; color:#2ec4b6; }
.status-3 { background:#fdecea; color:#e63946; }

.empty-state { text-align:center; padding:40px; color:var(--text-muted); }
.empty-state i { font-size:40px; margin-bottom:12px; display:block; opacity:.4; }

@keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
</style>
@endpush

@section('content')
@php
    $statusMap = [
        0 => ['label'=>'Chờ xác nhận', 'class'=>'status-0', 'icon'=>'fa-clock'],
        1 => ['label'=>'Đã xác nhận',  'class'=>'status-1', 'icon'=>'fa-check-circle'],
        2 => ['label'=>'Hoàn thành',   'class'=>'status-2', 'icon'=>'fa-check-double'],
        3 => ['label'=>'Đã huỷ',       'class'=>'status-3', 'icon'=>'fa-times-circle'],
    ];
@endphp

{{-- Hero --}}
<div class="admin-hero">
    <div class="date-badge"><i class="fas fa-calendar-day"></i> {{ now()->format('l, d/m/Y') }}</div>
    <h1>Xin chào, {{ auth()->user()->full_name }} 👋</h1>
    <p>Tổng quan hệ thống phòng khám nha khoa</p>
</div>

{{-- Stats --}}
<div class="row mb-4">
    <div class="col-6 col-lg-3 mb-3">
        <a href="{{ route('admin.accounts') }}" class="stat-card" style="animation-delay:.04s">
            <div class="stat-icon" style="background:#e8ecff"><i class="fas fa-users" style="color:#4361ee"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Tài khoản</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <a href="{{ route('admin.doctors') }}" class="stat-card" style="animation-delay:.07s">
            <div class="stat-icon" style="background:#f0e8ff"><i class="fas fa-user-md" style="color:#7209b7"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalDoctors }}</div>
                <div class="stat-label">Bác sĩ</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <a href="{{ route('admin.patients') }}" class="stat-card" style="animation-delay:.10s">
            <div class="stat-icon" style="background:#e6faf8"><i class="fas fa-hospital-user" style="color:#2ec4b6"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalPatients }}</div>
                <div class="stat-label">Bệnh nhân</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="stat-card" style="animation-delay:.13s">
            <div class="stat-icon" style="background:#fff8e1"><i class="fas fa-calendar-check" style="color:#f4a100"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="stat-label">Lịch đặt</div>
            </div>
        </div>
    </div>
</div>

{{-- Booking status row --}}
<div class="booking-stat-row">
    <div class="booking-stat-item"><div class="bval total">{{ $totalBookings }}</div><div class="blabel">Tất cả</div></div>
    <div style="width:1px;height:40px;background:#f0f0f0"></div>
    <div class="booking-stat-item"><div class="bval pending">{{ $pendingBookings }}</div><div class="blabel">Chờ xác nhận</div></div>
    <div style="width:1px;height:40px;background:#f0f0f0"></div>
    <div class="booking-stat-item"><div class="bval confirmed">{{ $confirmedBookings }}</div><div class="blabel">Đã xác nhận</div></div>
    <div style="width:1px;height:40px;background:#f0f0f0"></div>
    <div class="booking-stat-item"><div class="bval done">{{ $doneBookings }}</div><div class="blabel">Hoàn thành</div></div>
    <div style="width:1px;height:40px;background:#f0f0f0"></div>
    <div class="booking-stat-item"><div class="bval cancelled">{{ $cancelledBookings }}</div><div class="blabel">Đã huỷ</div></div>
</div>

{{-- Recent Bookings --}}
<div class="section-card">
    <div class="section-header">
        <h5>
            <div class="icon-wrap" style="background:#e8ecff"><i class="fas fa-calendar-alt" style="color:#4361ee"></i></div>
            Lịch đặt gần đây
        </h5>
        <a href="{{ route('admin.patients') }}" class="view-all-btn">Xem tất cả →</a>
    </div>

    @if($recentBookings->isEmpty())
        <div class="empty-state"><i class="fas fa-calendar-times"></i><p>Chưa có lịch đặt nào</p></div>
    @else
    <div class="table-responsive">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bệnh nhân</th>
                    <th>Bác sĩ</th>
                    <th>Ngày khám</th>
                    <th>Giờ khám</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $i => $bk)
                @php
                    $slot = $bk->slot; $schedule = $slot?->schedule; $doctor = $schedule?->doctor;
                   $patient = $bk->patient?->user;
                   $s = $statusMap[$bk->status] ?? $statusMap[0];
                @endphp
                <tr>
                    <td style="font-size:12px;color:#aaa;font-weight:600">{{ $i+1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($patient?->full_name ?? 'N') }}&background=4361ee&color=fff&size=36" class="pt-avatar">
                            <div><div class="pt-name">{{ $patient?->full_name ?? '—' }}</div><div class="pt-email">{{ $patient?->email ?? '' }}</div></div>
                        </div>
                    </td>
                    <td style="font-size:13px;font-weight:600;color:#1a1a2e">{{ $doctor?->full_name ?? '—' }}</td>
                    <td style="font-size:13px;font-weight:500">{{ $schedule?->work_date ? \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') : '—' }}</td>
                    <td style="font-size:13px">{{ $slot ? substr($slot->start_time,0,5).' - '.substr($slot->end_time,0,5) : '—' }}</td>
                    <td><span class="status-badge {{ $s['class'] }}"><i class="fas {{ $s['icon'] }}"></i> {{ $s['label'] }}</span></td>
                    <td style="font-size:12px;color:#aaa">{{ $bk->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
