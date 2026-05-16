@extends('layouts.admin')
@section('title', 'Quản lý Bệnh nhân')

@push('styles')
<style>
:root{--primary:#4361ee;--primary-light:#e8ecff;--success:#2ec4b6;--warning:#f4a100;--danger:#e63946;--purple:#7209b7;--text-dark:#1a1a2e;--text-muted:#6c757d;--shadow:0 4px 24px rgba(67,97,238,.10);--radius:14px;}
body{background:#f0f4ff!important;}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}

.page-hero{background:linear-gradient(135deg,#4361ee,#7209b7);border-radius:var(--radius);padding:26px 32px;color:white;margin-bottom:28px;animation:fadeUp .5s ease both;position:relative;overflow:hidden;}
.page-hero::before{content:'';position:absolute;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.07);top:-60px;right:-30px;}
.page-hero h2{font-size:22px;font-weight:800;margin:0 0 4px;position:relative;z-index:1;}
.page-hero p{margin:0;opacity:.85;font-size:13px;position:relative;z-index:1;}

/* Search bar */
.search-bar{background:white;border-radius:var(--radius);padding:16px 24px;box-shadow:var(--shadow);display:flex;align-items:center;gap:12px;margin-bottom:24px;animation:fadeUp .5s ease .05s both;}
.search-input{flex:1;border:2px solid #e8ecff;border-radius:10px;padding:10px 16px;font-size:14px;outline:none;transition:border-color .2s;}
.search-input:focus{border-color:var(--primary);}
.search-bar .total-badge{display:inline-flex;align-items:center;gap:6px;background:var(--primary-light);color:var(--primary);border-radius:20px;padding:6px 16px;font-size:12px;font-weight:700;white-space:nowrap;}

/* Patient card */
.patient-card{background:white;border-radius:var(--radius);box-shadow:var(--shadow);margin-bottom:20px;overflow:hidden;animation:fadeUp .5s ease both;transition:box-shadow .2s;}
.patient-card:hover{box-shadow:0 10px 36px rgba(67,97,238,.16);}
.patient-header{display:flex;align-items:center;gap:16px;padding:18px 24px;cursor:pointer;user-select:none;}
.patient-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-light);}
.patient-name{font-size:15px;font-weight:700;color:var(--text-dark);}
.patient-email{font-size:12px;color:var(--text-muted);}
.patient-meta{display:flex;gap:10px;margin-top:4px;flex-wrap:wrap;}
.meta-chip{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;border-radius:20px;padding:3px 10px;}
.chip-date{background:#e8ecff;color:var(--primary);}
.chip-count{background:#e6faf8;color:var(--success);}
.chip-none{background:#f5f5f5;color:#aaa;}
.expand-btn{margin-left:auto;background:var(--primary-light);border:none;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:13px;transition:transform .3s,background .2s;cursor:pointer;}
.expand-btn.open{transform:rotate(180deg);background:var(--primary);color:white;}

/* Bookings table inside card */
.bookings-panel{display:none;border-top:1px solid #f0f0f0;}
.bookings-panel.open{display:block;}
.bookings-inner{padding:0 24px 20px;}
.bk-table{width:100%;border-collapse:collapse;margin-top:12px;}
.bk-table th{font-size:10px;text-transform:uppercase;font-weight:700;color:var(--text-muted);letter-spacing:.6px;padding:10px 14px;background:#fafbff;border-bottom:2px solid #f0f0f0;}
.bk-table td{padding:11px 14px;border-bottom:1px solid #f8f8f8;vertical-align:middle;font-size:13px;}
.bk-table tr:last-child td{border-bottom:none;}
.bk-table tr:hover td{background:#fafbff;}

.status-badge{display:inline-flex;align-items:center;gap:4px;border-radius:20px;padding:3px 10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
.status-0{background:#fff8e1;color:#f4a100;}
.status-1{background:#e8ecff;color:#4361ee;}
.status-2{background:#e6faf8;color:#2ec4b6;}
.status-3{background:#fdecea;color:#e63946;}

.no-booking{text-align:center;padding:20px;color:var(--text-muted);font-size:13px;}
.no-booking i{display:block;font-size:24px;margin-bottom:8px;opacity:.4;}

.empty-state{text-align:center;padding:60px;color:var(--text-muted);}
.empty-state i{font-size:48px;margin-bottom:16px;display:block;opacity:.3;}
</style>
@endpush

@section('content')
@php
$statusMap=[0=>['label'=>'Chờ xác nhận','class'=>'status-0','icon'=>'fa-clock'],1=>['label'=>'Đã xác nhận','class'=>'status-1','icon'=>'fa-check-circle'],2=>['label'=>'Hoàn thành','class'=>'status-2','icon'=>'fa-check-double'],3=>['label'=>'Đã huỷ','class'=>'status-3','icon'=>'fa-times-circle']];
@endphp

{{-- Hero --}}
<div class="page-hero">
    <h2><i class="fas fa-hospital-user mr-2"></i> Danh sách Bệnh nhân</h2>
    <p>Xem thông tin và lịch sử đặt khám của từng bệnh nhân</p>
</div>

{{-- Search + count --}}
<div class="search-bar">
    <i class="fas fa-search" style="color:#aaa"></i>
    <input type="text" id="patient-search" class="search-input" placeholder="Tìm theo tên hoặc email...">
    <div class="total-badge"><i class="fas fa-users"></i> {{ $patients->count() }} bệnh nhân</div>
</div>

{{-- Patient list --}}
@if($patients->isEmpty())
    <div class="empty-state">
        <i class="fas fa-user-slash"></i>
        <p>Chưa có bệnh nhân nào</p>
    </div>
@else
    @foreach($patients as $idx => $user)
    @php
        $bookings = $user->patient?->bookings ?? collect();
        $bookingCount = $bookings->count();
    @endphp
    <div class="patient-card" data-search="{{ strtolower($user->name.' '.$user->email) }}" style="animation-delay:{{ $idx * 0.04 }}s">
        <div class="patient-header" onclick="togglePanel({{ $user->id }})">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4361ee&color=fff&size=48"
                 class="patient-avatar" alt="{{ $user->name }}">
            <div style="flex:1;min-width:0">
                <div class="patient-name">{{ $user->name }}</div>
                <div class="patient-email">{{ $user->email }}</div>
                <div class="patient-meta">
                    <span class="meta-chip chip-date">
                        <i class="fas fa-calendar-alt"></i>
                        Đăng ký: {{ $user->created_at->format('d/m/Y') }}
                    </span>
                    @if($bookingCount > 0)
                    <span class="meta-chip chip-count">
                        <i class="fas fa-calendar-check"></i>
                        {{ $bookingCount }} lịch đặt
                    </span>
                    @else
                    <span class="meta-chip chip-none">
                        <i class="fas fa-calendar-times"></i> Chưa đặt lịch
                    </span>
                    @endif
                </div>
            </div>
            <button type="button" class="expand-btn" id="btn-{{ $user->id }}">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        <div class="bookings-panel" id="panel-{{ $user->id }}">
            <div class="bookings-inner">
                @if($bookingCount === 0)
                    <div class="no-booking">
                        <i class="fas fa-calendar-times"></i>
                        Bệnh nhân này chưa có lịch đặt khám nào
                    </div>
                @else
                <table class="bk-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bác sĩ</th>
                            <th>Ngày khám</th>
                            <th>Giờ khám</th>
                            <th>Trạng thái</th>
                            <th>Lý do huỷ</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings->sortByDesc('created_at') as $bi => $bk)
                        @php
                            $slot = $bk->timeSlot;
                            $schedule = $slot?->doctorSchedule;
                            $doctor = $schedule?->doctor;
                            $s = $statusMap[$bk->status] ?? $statusMap[0];
                        @endphp
                        <tr>
                            <td style="color:#aaa;font-weight:600">{{ $bi+1 }}</td>
                            <td style="font-weight:600;color:#1a1a2e">{{ $doctor?->full_name ?? '—' }}</td>
                            <td>{{ $schedule?->work_date ? \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') : '—' }}</td>
                            <td>{{ $slot ? substr($slot->start_time,0,5).' - '.substr($slot->end_time,0,5) : '—' }}</td>
                            <td><span class="status-badge {{ $s['class'] }}"><i class="fas {{ $s['icon'] }}"></i> {{ $s['label'] }}</span></td>
                            <td style="color:#aaa;font-size:12px">{{ $bk->cancel_reason ?? '—' }}</td>
                            <td style="color:#aaa;font-size:12px">{{ $bk->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif
@endsection

@push('scripts')
<script>
function togglePanel(id) {
    const panel = document.getElementById('panel-' + id);
    const btn   = document.getElementById('btn-' + id);
    panel.classList.toggle('open');
    btn.classList.toggle('open');
}

// Live search
document.getElementById('patient-search').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.patient-card').forEach(card => {
        card.style.display = card.dataset.search.includes(q) ? '' : 'none';
    });
});
</script>
@endpush

