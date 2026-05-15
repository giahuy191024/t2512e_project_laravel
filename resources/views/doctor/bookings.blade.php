@extends('layouts.doctordashboard')
@section('title', 'Lịch khám bệnh nhân')

@section('content')
<style>
    /* ===== STATS ROW ===== */
    .bk-stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        animation: fadeUp .4s ease both;
        transition: transform .2s, box-shadow .2s;
        border-left: 4px solid transparent;
    }
    .bk-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .bk-stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .bk-stat-label { font-size: .72rem; color: #9aa0a6; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
    .bk-stat-value { font-size: 1.8rem; font-weight: 800; color: #3c4043; line-height: 1; }

    /* ===== FILTER TABS ===== */
    .bk-tabs {
        display: flex; gap: 8px; flex-wrap: wrap;
        margin: 22px 0 18px;
    }
    .bk-tab {
        padding: 7px 18px; border-radius: 20px; cursor: pointer;
        font-size: .82rem; font-weight: 700;
        border: 2px solid #dadce0; background: #fff; color: #5f6368;
        transition: all .2s ease; user-select: none;
    }
    .bk-tab:hover { border-color: #1a73e8; color: #1a73e8; }
    .bk-tab.active {
        background: linear-gradient(135deg,#1a73e8,#0d47a1);
        border-color: transparent; color: #fff;
        box-shadow: 0 4px 12px rgba(26,115,232,.3);
    }
    .bk-tab .cnt {
        background: rgba(255,255,255,.25); border-radius: 10px;
        padding: 0 7px; font-size: .7rem; margin-left: 4px;
    }
    .bk-tab:not(.active) .cnt { background: #f1f3f4; color: #5f6368; }

    /* ===== BOOKING ROW CARD ===== */
    .bk-row {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        margin-bottom: 12px; overflow: hidden;
        display: flex; align-items: stretch;
        transition: transform .2s, box-shadow .2s;
        animation: fadeUp .4s ease both;
    }
    .bk-row:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }

    .bk-side-bar { width: 5px; flex-shrink: 0; }
    .bk-side-bar.pending   { background: linear-gradient(#f59e0b,#d97706); }
    .bk-side-bar.confirmed { background: linear-gradient(#10b981,#059669); }
    .bk-side-bar.done      { background: linear-gradient(#6366f1,#4f46e5); }
    .bk-side-bar.cancelled { background: linear-gradient(#ef4444,#dc2626); }

    /* Số thứ tự */
    .bk-index {
        width: 46px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: .9rem; color: #9aa0a6;
        border-right: 1px solid #f1f3f4;
    }

    /* Avatar bệnh nhân */
    .bk-avatar-wrap {
        width: 64px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; padding: 10px 0;
    }
    .bk-avatar-wrap img {
        width: 44px; height: 44px; border-radius: 50%;
        object-fit: cover; border: 2px solid #e8f0fe;
    }

    /* Thông tin chính */
    .bk-main { flex: 1; padding: 12px 14px; }
    .bk-patient-name { font-weight: 800; font-size: .95rem; color: #3c4043; margin-bottom: 3px; }
    .bk-meta-row { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 6px; }
    .bk-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: .76rem; color: #5f6368;
    }
    .bk-meta-item i { color: #1a73e8; width: 13px; text-align: center; }

    /* Right: status + actions */
    .bk-actions {
        display: flex; flex-direction: column;
        align-items: flex-end; justify-content: center;
        padding: 12px 16px; gap: 8px; flex-shrink: 0; min-width: 160px;
    }
    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        border-radius: 20px; padding: 4px 12px;
        font-size: .72rem; font-weight: 700;
    }
    .status-pill.pending   { background:#fef3c7; color:#d97706; }
    .status-pill.confirmed { background:#d1fae5; color:#059669; }
    .status-pill.done      { background:#ede9fe; color:#4f46e5; }
    .status-pill.cancelled { background:#fee2e2; color:#dc2626; }

    .action-btns { display: flex; gap: 6px; }
    .btn-sm-act {
        border: none; border-radius: 8px; padding: 5px 12px;
        font-size: .72rem; font-weight: 700; cursor: pointer;
        transition: transform .15s, box-shadow .15s;
    }
    .btn-sm-act:hover { transform: translateY(-1px); }
    .btn-confirm-act { background: linear-gradient(135deg,#10b981,#059669); color:#fff; }
    .btn-confirm-act:hover { box-shadow: 0 4px 12px rgba(16,185,129,.4); }
    .btn-done-act { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; }
    .btn-done-act:hover { box-shadow: 0 4px 12px rgba(99,102,241,.4); }
    .btn-cancel-act { background: linear-gradient(135deg,#ef4444,#dc2626); color:#fff; }
    .btn-cancel-act:hover { box-shadow: 0 4px 12px rgba(239,68,68,.4); }

    /* ===== EMPTY STATE ===== */
    .bk-empty {
        text-align: center; padding: 60px 20px;
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
    }
    .bk-empty i { font-size: 56px; color: #dadce0; display: block; margin-bottom: 14px; }
    .bk-empty h5 { color: #5f6368; font-weight: 700; }

    /* ===== SUCCESS TOAST ===== */
    .toast-success {
        position: fixed; top: 20px; right: 20px; z-index: 9999;
        background: linear-gradient(135deg,#10b981,#059669);
        color: #fff; border-radius: 12px;
        padding: 12px 20px; font-weight: 600; font-size: .88rem;
        box-shadow: 0 6px 20px rgba(16,185,129,.4);
        animation: slideInRight .3s ease both;
    }
    @keyframes slideInRight {
        from { opacity:0; transform:translateX(40px); }
        to   { opacity:1; transform:translateX(0); }
    }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .bk-row:nth-child(2)  { animation-delay:.05s; }
    .bk-row:nth-child(3)  { animation-delay:.10s; }
    .bk-row:nth-child(4)  { animation-delay:.15s; }
    .bk-row:nth-child(5)  { animation-delay:.20s; }
    .bk-row:nth-child(6)  { animation-delay:.25s; }
    .bk-row:nth-child(7)  { animation-delay:.30s; }
</style>

@if(session('success'))
    <div class="toast-success" id="toast">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    </div>
@endif

@php
$statusMap = [
    0 => ['label'=>'Chờ xác nhận','class'=>'pending',  'icon'=>'fa-clock'],
    1 => ['label'=>'Đã xác nhận', 'class'=>'confirmed','icon'=>'fa-check-circle'],
    2 => ['label'=>'Đã khám',     'class'=>'done',     'icon'=>'fa-tooth'],
    3 => ['label'=>'Đã huỷ',      'class'=>'cancelled','icon'=>'fa-times-circle'],
];
@endphp

{{-- ===== STATS ===== --}}
<div class="row mb-4">
    <div class="col-xl col-md-4 col-6 mb-3">
        <div class="bk-stat-card" style="border-color:#1a73e8">
            <div class="bk-stat-icon" style="background:#e8f0fe"><i class="fas fa-list text-primary"></i></div>
            <div><div class="bk-stat-label">Tổng lịch hẹn</div><div class="bk-stat-value">{{ $stats['total'] }}</div></div>
        </div>
    </div>
    <div class="col-xl col-md-4 col-6 mb-3">
        <div class="bk-stat-card" style="border-color:#f59e0b">
            <div class="bk-stat-icon" style="background:#fef3c7"><i class="fas fa-clock" style="color:#d97706"></i></div>
            <div><div class="bk-stat-label">Chờ xác nhận</div><div class="bk-stat-value">{{ $stats['pending'] }}</div></div>
        </div>
    </div>
    <div class="col-xl col-md-4 col-6 mb-3">
        <div class="bk-stat-card" style="border-color:#10b981">
            <div class="bk-stat-icon" style="background:#d1fae5"><i class="fas fa-check-circle" style="color:#059669"></i></div>
            <div><div class="bk-stat-label">Đã xác nhận</div><div class="bk-stat-value">{{ $stats['confirmed'] }}</div></div>
        </div>
    </div>
    <div class="col-xl col-md-4 col-6 mb-3">
        <div class="bk-stat-card" style="border-color:#6366f1">
            <div class="bk-stat-icon" style="background:#ede9fe"><i class="fas fa-tooth" style="color:#4f46e5"></i></div>
            <div><div class="bk-stat-label">Đã khám xong</div><div class="bk-stat-value">{{ $stats['done'] }}</div></div>
        </div>
    </div>
    <div class="col-xl col-md-4 col-6 mb-3">
        <div class="bk-stat-card" style="border-color:#ef4444">
            <div class="bk-stat-icon" style="background:#fee2e2"><i class="fas fa-times-circle" style="color:#dc2626"></i></div>
            <div><div class="bk-stat-label">Đã huỷ</div><div class="bk-stat-value">{{ $stats['cancelled'] }}</div></div>
        </div>
    </div>
</div>

{{-- ===== FILTER TABS ===== --}}
<div class="bk-tabs">
    <div class="bk-tab active" data-tab="all">Tất cả <span class="cnt">{{ $stats['total'] }}</span></div>
    <div class="bk-tab" data-tab="0">Chờ xác nhận <span class="cnt">{{ $stats['pending'] }}</span></div>
    <div class="bk-tab" data-tab="1">Đã xác nhận <span class="cnt">{{ $stats['confirmed'] }}</span></div>
    <div class="bk-tab" data-tab="2">Đã khám <span class="cnt">{{ $stats['done'] }}</span></div>
    <div class="bk-tab" data-tab="3">Đã huỷ <span class="cnt">{{ $stats['cancelled'] }}</span></div>
</div>

{{-- ===== DANH SÁCH ===== --}}
<div id="bk-list">
    @forelse($bookings as $i => $bk)
    @php
        $slot     = $bk->timeSlot;
        $schedule = $slot?->doctorSchedule;
        $patient  = $bk->patient;
        $user     = $patient?->user;
        $st       = $statusMap[$bk->status] ?? $statusMap[0];
        $patientName = $patient?->full_name ?? $user?->name ?? 'Bệnh nhân #' . ($patient?->id ?? '?');
        $patientId   = ($user?->id ?? $bk->patient_id ?? 1);
    @endphp
    <div class="bk-row" data-status="{{ $bk->status }}">
        <div class="bk-side-bar {{ $st['class'] }}"></div>

        {{-- STT --}}
        <div class="bk-index">{{ $i + 1 }}</div>

        {{-- Avatar --}}
        <div class="bk-avatar-wrap">
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($patientName) }}&background=e8f0fe&color=1a73e8&size=128&bold=true"
                alt="{{ $patientName }}"
            >
        </div>

        {{-- Thông tin bệnh nhân & lịch --}}
        <div class="bk-main">
            <div class="bk-patient-name">
                <i class="fas fa-user-injured text-primary mr-1" style="font-size:.85rem"></i>
                {{ $patientName }}
            </div>
            @if($user?->email)
            <div style="font-size:.74rem;color:#9aa0a6">{{ $user->email }}</div>
            @endif
            <div class="bk-meta-row">
                <div class="bk-meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $schedule ? \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') : '—' }}</span>
                </div>
                <div class="bk-meta-item">
                    <i class="far fa-clock"></i>
                    <span>
                        {{ $slot ? \Carbon\Carbon::parse($slot->start_time)->format('H:i') : '—' }}
                        @if($slot?->end_time) – {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }} @endif
                    </span>
                </div>
                <div class="bk-meta-item">
                    <i class="fas fa-hashtag"></i>
                    <span>#{{ str_pad($bk->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="bk-meta-item">
                    <i class="far fa-calendar-plus"></i>
                    <span>Đặt lúc {{ $bk->created_at->format('H:i d/m/Y') }}</span>
                </div>
                @if($patient?->phone_number)
                <div class="bk-meta-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>{{ $patient->phone_number }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Status + Actions --}}
        <div class="bk-actions">
            <span class="status-pill {{ $st['class'] }}">
                <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
            </span>
            <div class="action-btns">
                @if($bk->status === 0)
                    {{-- Pending: Xác nhận hoặc Huỷ --}}
                    <form action="{{ route('doctor.bookings.updateStatus', $bk->id) }}" method="POST">
                        @csrf @method('POST')
                        <input type="hidden" name="status" value="1">
                        <button class="btn-sm-act btn-confirm-act" title="Xác nhận">
                            <i class="fas fa-check mr-1"></i>Duyệt
                        </button>
                    </form>
                    <form action="{{ route('doctor.bookings.updateStatus', $bk->id) }}" method="POST">
                        @csrf @method('POST')
                        <input type="hidden" name="status" value="3">
                        <button class="btn-sm-act btn-cancel-act" title="Huỷ"
                            onclick="return confirm('Xác nhận huỷ lịch hẹn này?')">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @elseif($bk->status === 1)
                    {{-- Confirmed: Đánh dấu đã khám --}}
                    <form action="{{ route('doctor.bookings.updateStatus', $bk->id) }}" method="POST">
                        @csrf @method('POST')
                        <input type="hidden" name="status" value="2">
                        <button class="btn-sm-act btn-done-act" title="Đánh dấu đã khám">
                            <i class="fas fa-tooth mr-1"></i>Hoàn thành
                        </button>
                    </form>
                    <form action="{{ route('doctor.bookings.updateStatus', $bk->id) }}" method="POST">
                        @csrf @method('POST')
                        <input type="hidden" name="status" value="3">
                        <button class="btn-sm-act btn-cancel-act" title="Huỷ"
                            onclick="return confirm('Xác nhận huỷ lịch hẹn này?')">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @else
                    <span style="font-size:.7rem;color:#9aa0a6">Không có hành động</span>
                @endif
            </div>
        </div>
    </div>
    @empty
        <div class="bk-empty">
            <i class="far fa-calendar-times"></i>
            <h5>Chưa có lịch hẹn nào</h5>
            <p style="font-size:.85rem;color:#9aa0a6">Bệnh nhân chưa đặt lịch khám với bạn.</p>
        </div>
    @endforelse
</div>

<script>
    // Filter tabs
    document.querySelectorAll('.bk-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.bk-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.tab;
            document.querySelectorAll('.bk-row').forEach(function(row) {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = 'flex';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Auto ẩn toast sau 3 giây
    const toast = document.getElementById('toast');
    if (toast) setTimeout(() => toast.style.opacity = '0', 3000);
</script>
@endsection
