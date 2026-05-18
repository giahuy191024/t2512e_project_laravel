@extends('layouts.patient')
@section('title', 'Trang chủ Bệnh nhân')

@push('styles')
<style>
    /* ===== HERO BANNER ===== */
    .dash-hero {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 60%, #01579b 100%);
        border-radius: 20px;
        padding: 40px 36px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        animation: heroIn .6s cubic-bezier(.34,1.56,.64,1) both;
    }
    .dash-hero::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        right: 60px; bottom: -60px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }
    .dash-hero h2 { font-size: 2rem; font-weight: 800; margin-bottom: 6px; }
    .dash-hero p  { font-size: 1rem; opacity: .85; margin-bottom: 20px; }
    .dash-hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .btn-hero-primary {
        background: #fff; color: #1a73e8;
        border-radius: 12px; font-weight: 700;
        padding: 10px 22px; border: none;
        transition: transform .15s, box-shadow .15s;
        font-size: .9rem;
    }
    .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.15); color:#1a73e8; text-decoration:none; }
    .btn-hero-outline {
        background: transparent; color: #fff;
        border: 2px solid rgba(255,255,255,.6);
        border-radius: 12px; font-weight: 700;
        padding: 10px 22px;
        transition: background .2s, border-color .2s;
        font-size: .9rem;
    }
    .btn-hero-outline:hover { background: rgba(255,255,255,.15); border-color:#fff; color:#fff; text-decoration:none; }

    /* ===== STATS ROW ===== */
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        display: flex; align-items: center; gap: 16px;
        animation: fadeInUp .5s ease both;
        border: none;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,.10); }
    .stat-icon-wrap {
        width: 54px; height: 54px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .stat-label { font-size: .73rem; color: #9aa0a6; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .stat-value { font-size: 1.6rem; font-weight: 800; color: #3c4043; line-height: 1; }

    /* ===== ACTION CARDS ===== */
    .action-card {
        background: #fff;
        border-radius: 18px;
        padding: 30px 24px;
        text-align: center;
        box-shadow: 0 2px 14px rgba(0,0,0,.06);
        border: none;
        position: relative;
        overflow: hidden;
        animation: fadeInUp .5s ease both;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s;
        height: 100%;
    }
    .action-card:hover { transform: translateY(-8px); box-shadow: 0 18px 40px rgba(0,0,0,.12); }
    .action-card .card-bg-icon {
        position: absolute; right: -10px; bottom: -10px;
        font-size: 90px; opacity: .05;
        pointer-events: none;
    }
    .action-card .action-icon {
        width: 70px; height: 70px;
        border-radius: 20px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin-bottom: 16px;
    }
    .action-card h4 { font-weight: 700; font-size: 1.05rem; color: #3c4043; margin-bottom: 8px; }
    .action-card p  { color: #6c757d; font-size: .85rem; margin-bottom: 20px; }
    .btn-action {
        border-radius: 10px; font-weight: 700;
        padding: 9px 24px; font-size: .88rem;
        border: none; transition: transform .15s, box-shadow .15s;
        text-decoration: none; display: inline-block;
    }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.2); text-decoration: none; }

    /* ===== TIPS SECTION ===== */
    .tips-section { margin-top: 28px; }
    .tip-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex; align-items: flex-start; gap: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
        animation: fadeInUp .5s ease both;
        transition: transform .2s;
    }
    .tip-card:hover { transform: translateY(-3px); }
    .tip-icon { font-size: 1.8rem; flex-shrink: 0; }
    .tip-title { font-weight: 700; font-size: .88rem; color: #3c4043; margin-bottom: 3px; }
    .tip-desc  { font-size: .78rem; color: #6c757d; line-height: 1.5; }

    /* ===== ANIMATIONS ===== */
    @keyframes heroIn {
        from { opacity: 0; transform: scale(.97) translateY(10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-col:nth-child(1) .stat-card    { animation-delay: .1s; }
    .stat-col:nth-child(2) .stat-card    { animation-delay: .18s; }
    .stat-col:nth-child(3) .stat-card    { animation-delay: .26s; }
    .action-col:nth-child(1) .action-card { animation-delay: .15s; }
    .action-col:nth-child(2) .action-card { animation-delay: .25s; }
    .action-col:nth-child(3) .action-card { animation-delay: .35s; }
    .tip-col:nth-child(1) .tip-card { animation-delay: .2s; }
    .tip-col:nth-child(2) .tip-card { animation-delay: .3s; }
    .tip-col:nth-child(3) .tip-card { animation-delay: .4s; }

    /* ===== CANCEL NOTIFICATIONS ===== */
    .notif-wrap {
        margin-bottom: 22px;
        animation: fadeInUp .4s ease both;
    }
    .notif-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 10px;
    }
    .notif-header-title {
        font-size: .8rem; font-weight: 700; color: #dc2626;
        text-transform: uppercase; letter-spacing: .5px;
    }
    .notif-header-title i { margin-right: 5px; }
    .btn-mark-all {
        font-size: .72rem; color: #6c757d; font-weight: 600;
        background: none; border: 1px solid #dadce0;
        border-radius: 8px; padding: 3px 12px; cursor: pointer;
        transition: background .2s;
        text-decoration: none;
    }
    .btn-mark-all:hover { background: #f1f3f4; color: #3c4043; text-decoration: none; }
    .notif-item {
        display: flex; align-items: flex-start; gap: 14px;
        background: #fff;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-left: 4px solid #ef4444;
        box-shadow: 0 2px 10px rgba(239,68,68,.10);
        animation: fadeInUp .4s ease both;
        position: relative;
    }
    .notif-icon-wrap {
        width: 40px; height: 40px; flex-shrink: 0;
        background: #fee2e2; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #dc2626; font-size: 1rem;
    }
    .notif-body { flex: 1; }
    .notif-title { font-weight: 700; font-size: .88rem; color: #3c4043; margin-bottom: 3px; }
    .notif-detail { font-size: .78rem; color: #6c757d; line-height: 1.5; }
    .notif-time { font-size: .7rem; color: #9aa0a6; margin-top: 4px; }
    .notif-dismiss {
        background: none; border: none; color: #9aa0a6;
        cursor: pointer; font-size: .85rem; padding: 2px 6px;
        border-radius: 6px; transition: background .15s, color .15s;
        flex-shrink: 0; align-self: center;
    }
    .notif-dismiss:hover { background: #fee2e2; color: #dc2626; }
    .notif-dot {
        position: absolute; top: 10px; right: 14px;
        width: 8px; height: 8px; border-radius: 50%;
        background: #ef4444;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0%,100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.4); opacity: .6; }
    }
</style>
@endpush

@section('content')

{{-- ===== THÔNG BÁO HUỶ LỊCH ===== --}}
@if($cancelledUnread->isNotEmpty())
<div class="notif-wrap">
    <div class="notif-header">
        <span class="notif-header-title">
            <i class="fas fa-bell"></i>
            Thông báo ({{ $cancelledUnread->count() }})
        </span>
        <form action="{{ route('patient.notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="btn-mark-all">
                <i class="fas fa-check-double mr-1"></i> Đánh dấu tất cả đã đọc
            </button>
        </form>
    </div>

    @foreach($cancelledUnread as $bk)
    @php
        $sched  = $bk->timeSlot?->doctorSchedule;
        $doctor = $sched?->doctor;
    @endphp
    <div class="notif-item">
        <div class="notif-dot"></div>
        <div class="notif-icon-wrap">
            <i class="fas fa-calendar-times"></i>
        </div>
        <div class="notif-body">
            <div class="notif-title">Lịch hẹn của bạn đã bị huỷ</div>
            <div class="notif-detail">
                Lịch khám với <strong>BS. {{ $doctor?->full_name ?? 'Bác sĩ' }}</strong>
                @if($sched)
                    vào <strong>{{ \Carbon\Carbon::parse($sched->work_date)->format('d/m/Y') }}</strong>
                @endif
                @if($bk->timeSlot)
                    lúc <strong>{{ \Carbon\Carbon::parse($bk->timeSlot->start_time)->format('H:i') }}</strong>
                @endif
                đã bị huỷ.
                @if($bk->cancel_reason)
                    <br><span class="text-muted">Lý do: {{ $bk->cancel_reason }}</span>
                @endif
            </div>
            <div class="notif-time">
                <i class="far fa-clock mr-1"></i>{{ $bk->updated_at->diffForHumans() }}
            </div>
        </div>
        <form action="{{ route('patient.notifications.read', $bk->id) }}" method="POST">
            @csrf
            <button type="submit" class="notif-dismiss" title="Đã hiểu, đóng thông báo">
                <i class="fas fa-times"></i>
            </button>
        </form>
    </div>
    @endforeach
</div>
@endif

{{-- ===== HERO BANNER ===== --}}
<div class="dash-hero">
    <h2>Xin chào, {{ auth()->user()->name }}! 👋</h2>
    <p>Hôm nay bạn cảm thấy thế nào? Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>
    <div class="dash-hero-actions">
        <a href="{{ route('patient.doctors') }}" class="btn-hero-primary">
            <i class="fas fa-user-md mr-1"></i> Tìm bác sĩ ngay
        </a>
        <a href="{{ route('patient.appointments') }}" class="btn-hero-outline">
            <i class="far fa-calendar-alt mr-1"></i> Lịch hẹn của tôi
        </a>
    </div>
</div>

{{-- ===== STATS ===== --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3 stat-col">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#e8f0fe">
                <i class="far fa-calendar-check" style="color:#1a73e8"></i>
            </div>
            <div>
                <div class="stat-label">Lịch hẹn sắp tới</div>
                <div class="stat-value">{{ $upcomingCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 stat-col">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#e6f4ea">
                <i class="fas fa-history" style="color:#2e7d32"></i>
            </div>
            <div>
                <div class="stat-label">Lần khám đã qua</div>
                <div class="stat-value">{{ $pastCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 stat-col">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#fce8e6">
                <i class="fas fa-bell" style="color:#c62828"></i>
            </div>
            <div>
                <div class="stat-label">Thông báo mới</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ACTION CARDS ===== --}}
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-4 action-col">
        <div class="action-card">
            <i class="fas fa-user-md card-bg-icon"></i>
            <div class="action-icon" style="background:#e8f0fe">
                <i class="fas fa-user-md" style="color:#1a73e8"></i>
            </div>
            <h4>Đặt lịch khám</h4>
            <p>Tìm bác sĩ giỏi theo chuyên khoa và thành phố, đặt lịch hẹn nhanh chóng.</p>
            <a href="{{ route('patient.doctors') }}" class="btn-action text-white" style="background:linear-gradient(135deg,#1a73e8,#0d47a1)">
                <i class="fas fa-search mr-1"></i> Tìm Bác Sĩ
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4 action-col">
        <div class="action-card">
            <i class="fas fa-calendar-check card-bg-icon"></i>
            <div class="action-icon" style="background:#e6f4ea">
                <i class="fas fa-calendar-check" style="color:#2e7d32"></i>
            </div>
            <h4>Quản lý lịch hẹn</h4>
            <p>Xem lại các lịch hẹn sắp tới, theo dõi trạng thái và lịch sử khám bệnh.</p>
            <a href="{{ route('patient.appointments') }}" class="btn-action text-white" style="background:linear-gradient(135deg,#2e7d32,#1b5e20)">
                <i class="far fa-calendar-alt mr-1"></i> Xem Lịch Hẹn
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4 action-col">
        <div class="action-card">
            <i class="fas fa-id-card card-bg-icon"></i>
            <div class="action-icon" style="background:#fff3e0">
                <i class="fas fa-id-card" style="color:#e65100"></i>
            </div>
            <h4>Hồ sơ cá nhân</h4>
            <p>Cập nhật thông tin cá nhân, tiền sử bệnh lý và thông tin liên hệ khẩn cấp.</p>
            <a href="{{ route('patient.profile') }}" class="btn-action text-white" style="background:linear-gradient(135deg,#f57c00,#e65100)">
                <i class="fas fa-edit mr-1"></i> Cập Nhật Hồ Sơ
            </a>
        </div>
    </div>
</div>

{{-- ===== HEALTH TIPS ===== --}}
<div class="tips-section">
    <h5 class="font-weight-bold mb-3" style="color:#3c4043">
        <i class="fas fa-lightbulb text-warning mr-2"></i>Mẹo sức khoẻ hôm nay
    </h5>
    <div class="row">
        <div class="col-md-4 mb-3 tip-col">
            <div class="tip-card">
                <span class="tip-icon">💧</span>
                <div>
                    <div class="tip-title">Uống đủ nước</div>
                    <div class="tip-desc">Uống ít nhất 2 lít nước mỗi ngày để cơ thể hoạt động tốt và da luôn tươi sáng.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 tip-col">
            <div class="tip-card">
                <span class="tip-icon">🚶</span>
                <div>
                    <div class="tip-title">Vận động 30 phút/ngày</div>
                    <div class="tip-desc">Đi bộ hoặc tập nhẹ 30 phút mỗi ngày giúp giảm nguy cơ tim mạch và tăng cường miễn dịch.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 tip-col">
            <div class="tip-card">
                <span class="tip-icon">😴</span>
                <div>
                    <div class="tip-title">Ngủ đủ giấc</div>
                    <div class="tip-desc">7–8 tiếng ngủ mỗi đêm giúp cơ thể phục hồi, cải thiện tập trung và tâm trạng.</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- ===== LEFT ADS ===== --}}
@push('left-ad')
    <div class="ad-card" style="animation-delay:.1s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">🦷</span>
            <div class="ad-card-title">Tẩy trắng răng</div>
            <div class="ad-card-desc">Công nghệ Laser Whitening, trắng sáng sau 1 buổi. Giảm 30% tháng này!</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#1a73e8,#0d47a1)">Đặt lịch ngay</a>
        </div>
    </div>
    <div class="ad-card" style="animation-delay:.2s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">😁</span>
            <div class="ad-card-title">Niềng răng Invisalign</div>
            <div class="ad-card-desc">Máng niềng trong suốt, thoải mái & thẩm mỹ. Tư vấn miễn phí.</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#7b1fa2,#4a148c)">Tư vấn ngay</a>
        </div>
    </div>
    <div class="ad-card" style="animation-delay:.3s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">🪥</span>
            <div class="ad-card-title">Bàn chải điện Oral-B</div>
            <div class="ad-card-desc">Làm sạch gấp 10 lần bàn chải thường. Mua ngay giảm 20%.</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#00897b,#004d40)">Mua ngay</a>
        </div>
    </div>
@endpush

{{-- ===== RIGHT ADS ===== --}}
@push('right-ad')
    <div class="ad-card" style="animation-delay:.15s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">💎</span>
            <div class="ad-card-title">Dán sứ Veneer</div>
            <div class="ad-card-desc">Nụ cười hoàn hảo chỉ sau 2 buổi. Sứ cao cấp bảo hành 10 năm.</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#f57c00,#e65100)">Xem chi tiết</a>
        </div>
    </div>
    <div class="ad-card" style="animation-delay:.25s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">🔬</span>
            <div class="ad-card-title">Cấy ghép Implant</div>
            <div class="ad-card-desc">Trồng răng cố định như răng thật. Titanium chuẩn FDA, bảo hành trọn đời.</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#1565c0,#0d47a1)">Tìm hiểu</a>
        </div>
    </div>
    <div class="ad-card" style="animation-delay:.35s">
        <div class="ad-card-label">Quảng cáo</div>
        <div class="ad-card-body">
            <span class="ad-card-icon">�</span>
            <div class="ad-card-title">Kem đánh răng Sensodyne</div>
            <div class="ad-card-desc">Giảm ê buốt tức thì, bảo vệ men răng lâu dài. Combo 3 tuýp giảm 15%.</div>
            <a href="#" class="ad-card-btn text-white" style="background:linear-gradient(135deg,#2e7d32,#1b5e20)">Mua combo</a>
        </div>
    </div>
@endpush
