@extends('layouts.patient')
@section('title', 'Quản lý lịch hẹn')

@push('styles')
<style>
    /* ===== HERO ===== */
    .appt-hero {
        background: linear-gradient(135deg, #0d47a1 0%, #1565c0 60%, #1976d2 100%);
        border-radius: 16px;
        padding: 32px 28px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        animation: fadeUp .5s ease both;
    }
    .appt-hero::after {
        content: '\f073';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        font-size: 130px; position: absolute;
        right: -10px; bottom: -20px;
        opacity: .06; color: #fff; pointer-events: none;
    }
    .appt-hero h2 { font-size: 1.7rem; font-weight: 800; margin-bottom: 4px; }
    .appt-hero p  { opacity: .8; margin: 0; font-size: .95rem; }

    /* ===== FILTER TABS ===== */
    .filter-tabs {
        display: flex; gap: 8px; flex-wrap: wrap;
        margin-bottom: 22px;
        animation: fadeUp .4s ease both;
    }
    .filter-tab {
        padding: 7px 18px; border-radius: 20px;
        font-size: .82rem; font-weight: 700; cursor: pointer;
        border: 2px solid #dadce0; background: #fff;
        color: #5f6368; transition: all .2s ease;
    }
    .filter-tab:hover { border-color: #1a73e8; color: #1a73e8; }
    .filter-tab.active {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        border-color: transparent; color: #fff;
        box-shadow: 0 4px 12px rgba(26,115,232,.3);
    }
    .filter-tab .tab-count {
        background: rgba(255,255,255,.25);
        border-radius: 10px; padding: 0 7px;
        font-size: .72rem; margin-left: 5px;
    }
    .filter-tab:not(.active) .tab-count {
        background: #f1f3f4; color: #5f6368;
    }

    /* ===== BOOKING CARD ===== */
    .booking-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(0,0,0,.06);
        margin-bottom: 14px;
        overflow: hidden;
        border: none;
        transition: transform .2s ease, box-shadow .2s ease;
        animation: fadeUp .4s ease both;
    }
    .booking-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0,0,0,.1);
    }
    .booking-card-inner {
        display: flex; align-items: stretch;
        min-height: 110px;
    }
    /* Thanh màu bên trái theo status */
    .booking-status-bar {
        width: 6px; flex-shrink: 0;
    }
    .booking-status-bar.pending  { background: linear-gradient(#f59e0b, #d97706); }
    .booking-status-bar.confirmed{ background: linear-gradient(#10b981, #059669); }
    .booking-status-bar.done     { background: linear-gradient(#6366f1, #4f46e5); }
    .booking-status-bar.cancelled{ background: linear-gradient(#ef4444, #dc2626); }

    /* Doctor photo */
    .bk-doctor-photo {
        width: 80px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        padding: 12px 0 12px 14px;
    }
    .bk-doctor-photo img {
        width: 60px; height: 60px; border-radius: 50%;
        object-fit: cover; border: 3px solid #e8f0fe;
    }

    /* Info */
    .bk-info { flex: 1; padding: 14px 16px; }
    .bk-doctor-name { font-weight: 800; font-size: 1rem; color: #3c4043; margin-bottom: 4px; }
    .bk-spec { font-size: .78rem; color: #1a73e8; font-weight: 600; margin-bottom: 10px; }
    .bk-meta { display: flex; flex-wrap: wrap; gap: 14px; }
    .bk-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: .78rem; color: #5f6368;
    }
    .bk-meta-item i { color: #1a73e8; width: 14px; text-align: center; }

    /* Status badge */
    .bk-right {
        display: flex; flex-direction: column;
        align-items: flex-end; justify-content: space-between;
        padding: 14px 18px;
        flex-shrink: 0; min-width: 130px;
    }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        border-radius: 20px; padding: 4px 12px;
        font-size: .72rem; font-weight: 700;
    }
    .status-badge.pending   { background: #fef3c7; color: #d97706; }
    .status-badge.confirmed { background: #d1fae5; color: #059669; }
    .status-badge.done      { background: #ede9fe; color: #4f46e5; }
    .status-badge.cancelled { background: #fee2e2; color: #dc2626; }

    .btn-cancel {
        font-size: .72rem; color: #ef4444; font-weight: 600;
        background: none; border: 1.5px solid #fee2e2;
        border-radius: 8px; padding: 4px 12px; cursor: pointer;
        transition: background .2s;
    }
    .btn-cancel:hover { background: #fee2e2; }

    /* ===== EMPTY STATE ===== */
    .empty-appt {
        text-align: center; padding: 70px 20px;
        background: #fff; border-radius: 16px;
        box-shadow: 0 2px 14px rgba(0,0,0,.06);
    }
    .empty-appt i { font-size: 60px; color: #dadce0; display: block; margin-bottom: 16px; }
    .empty-appt h5 { color: #5f6368; font-weight: 700; }
    .empty-appt p  { color: #9aa0a6; font-size: .88rem; }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .booking-card:nth-child(1)  { animation-delay: .05s; }
    .booking-card:nth-child(2)  { animation-delay: .10s; }
    .booking-card:nth-child(3)  { animation-delay: .15s; }
    .booking-card:nth-child(4)  { animation-delay: .20s; }
    .booking-card:nth-child(5)  { animation-delay: .25s; }
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<div class="appt-hero">
    <h2><i class="far fa-calendar-alt mr-2"></i> Lịch hẹn của tôi</h2>
    <p>Theo dõi và quản lý toàn bộ lịch khám răng của bạn</p>
</div>

@php
    $statusMap = [
        0 => ['label' => 'Chờ xác nhận', 'class' => 'pending',   'icon' => 'fa-clock'],
        1 => ['label' => 'Đã xác nhận',  'class' => 'confirmed', 'icon' => 'fa-check-circle'],
        2 => ['label' => 'Đã khám',      'class' => 'done',      'icon' => 'fa-tooth'],
        3 => ['label' => 'Đã huỷ',       'class' => 'cancelled', 'icon' => 'fa-times-circle'],
    ];

    $all       = $bookings;
    $upcoming  = $bookings->filter(fn($b) => in_array($b->status, [0,1]));
    $done      = $bookings->filter(fn($b) => $b->status === 2);
    $cancelled = $bookings->filter(fn($b) => $b->status === 3);
@endphp

{{-- ===== FILTER TABS ===== --}}
<div class="filter-tabs">
    <div class="filter-tab active" data-tab="all">
        Tất cả <span class="tab-count">{{ $all->count() }}</span>
    </div>
    <div class="filter-tab" data-tab="upcoming">
        Sắp tới <span class="tab-count">{{ $upcoming->count() }}</span>
    </div>
    <div class="filter-tab" data-tab="done">
        Đã khám <span class="tab-count">{{ $done->count() }}</span>
    </div>
    <div class="filter-tab" data-tab="cancelled">
        Đã huỷ <span class="tab-count">{{ $cancelled->count() }}</span>
    </div>
</div>

{{-- ===== DANH SÁCH LỊCH HẸN ===== --}}
@foreach([
    'all'       => $all,
    'upcoming'  => $upcoming,
    'done'      => $done,
    'cancelled' => $cancelled,
] as $tabKey => $list)
<div class="tab-content-section" id="tab-{{ $tabKey }}" style="{{ $tabKey !== 'all' ? 'display:none' : '' }}">

    @forelse($list as $booking)
    @php
        $slot     = $booking->timeSlot;
        $schedule = $slot?->doctorSchedule;
        $doctor   = $schedule?->doctor;
        $st       = $statusMap[$booking->status] ?? $statusMap[0];
        $photoId  = (($doctor?->id ?? 1) % 70) + 1;
        $gender   = (($doctor?->id ?? 1) % 2 === 0) ? 'men' : 'women';
    @endphp
    <div class="booking-card">
        <div class="booking-card-inner">

            {{-- Thanh màu status --}}
            <div class="booking-status-bar {{ $st['class'] }}"></div>

            {{-- Ảnh bác sĩ --}}
            <div class="bk-doctor-photo">
                <img
                    src="https://randomuser.me/api/portraits/{{ $gender }}/{{ $photoId }}.jpg"
                    alt="{{ $doctor?->full_name }}"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($doctor?->full_name ?? 'BS') }}&background=1a73e8&color=fff&size=128&bold=true'"
                >
            </div>

            {{-- Thông tin --}}
            <div class="bk-info">
                <div class="bk-doctor-name">BS. {{ $doctor?->full_name ?? '—' }}</div>
                <div class="bk-spec">
                    <i class="fas fa-tooth mr-1"></i>{{ $doctor?->specialization?->name ?? 'Chuyên khoa' }}
                </div>
                <div class="bk-meta">
                    <div class="bk-meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $schedule ? \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') : '—' }}</span>
                    </div>
                    <div class="bk-meta-item">
                        <i class="far fa-clock"></i>
                        <span>{{ $slot ? \Carbon\Carbon::parse($slot->start_time)->format('H:i') : '—' }}</span>
                    </div>
                    <div class="bk-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $doctor?->city?->name ?? '—' }}</span>
                    </div>
                    <div class="bk-meta-item">
                        <i class="fas fa-hashtag"></i>
                        <span>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            {{-- Status + action --}}
            <div class="bk-right">
                <span class="status-badge {{ $st['class'] }}">
                    <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
                </span>

                @if(in_array($booking->status, [0, 1]))
                    <form action="#" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cancel"
                            onclick="return confirm('Bạn chắc chắn muốn huỷ lịch hẹn này?')">
                            <i class="fas fa-times mr-1"></i> Huỷ lịch
                        </button>
                    </form>
                @else
                    <span style="font-size:.7rem;color:#9aa0a6">{{ $booking->created_at->format('d/m/Y') }}</span>
                @endif
            </div>

        </div>
    </div>
    @empty
        <div class="empty-appt">
            <i class="far fa-calendar-times"></i>
            <h5>Không có lịch hẹn nào</h5>
            <p>Hãy đặt lịch khám để bắt đầu chăm sóc sức khoẻ răng miệng của bạn!</p>
            <a href="{{ route('patient.doctors') }}" class="btn btn-primary rounded-pill mt-2">
                <i class="fas fa-user-md mr-1"></i> Tìm bác sĩ ngay
            </a>
        </div>
    @endforelse

</div>
@endforeach

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content-section').forEach(s => s.style.display = 'none');
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
        });
    });
</script>
@endpush
