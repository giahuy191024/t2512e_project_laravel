@extends('layouts.patient')
@section('title', 'Đặt lịch khám')

@push('styles')
<style>
    /* ===== LAYOUT ===== */
    .booking-wrap { display: flex; gap: 24px; align-items: flex-start; }
    .booking-sidebar { width: 270px; flex-shrink: 0; }
    .booking-main { flex: 1; min-width: 0; }
    @media(max-width:768px){
        .booking-wrap { flex-direction: column; }
        .booking-sidebar { width: 100%; }
    }

    /* ===== DOCTOR SIDEBAR CARD ===== */
    .doc-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        animation: fadeUp .5s ease both;
    }
    .doc-card-photo {
        height: 200px;
        position: relative;
        overflow: hidden;
    }
    .doc-card-photo img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: center top;
    }
    .doc-card-photo-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(13,71,161,.8) 100%);
    }
    .doc-card-photo-name {
        position: absolute; bottom: 12px; left: 14px; right: 14px;
        color: #fff;
    }
    .doc-card-photo-name h4 { font-size: 1.1rem; font-weight: 800; margin: 0 0 2px; }
    .doc-card-photo-name span { font-size: .75rem; opacity: .85; }
    .doc-card-body { padding: 16px 18px 20px; }
    .doc-info-row {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 0; border-bottom: 1px solid #f1f3f4;
        font-size: .85rem; color: #3c4043;
    }
    .doc-info-row:last-child { border-bottom: none; }
    .doc-info-row i { width: 20px; text-align: center; color: #1a73e8; }
    .doc-stars { color: #fbbc04; font-size: .8rem; }
    .doc-stars span { color: #6c757d; font-size: .75rem; margin-left: 4px; }

    /* ===== DATE SELECTOR BAR ===== */
    .date-bar-wrap {
        background: #fff;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
        margin-bottom: 20px;
        animation: fadeUp .4s ease both;
    }
    .date-bar-title {
        font-size: .75rem; font-weight: 700; color: #5f6368;
        text-transform: uppercase; letter-spacing: .5px;
        margin-bottom: 14px;
    }
    .date-bar {
        display: flex; gap: 10px; overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: thin; scrollbar-color: #dadce0 transparent;
    }
    .date-bar::-webkit-scrollbar { height: 4px; }
    .date-bar::-webkit-scrollbar-track { background: transparent; }
    .date-bar::-webkit-scrollbar-thumb { background: #dadce0; border-radius: 4px; }
    .date-btn {
        flex-shrink: 0;
        display: flex; flex-direction: column; align-items: center;
        padding: 10px 18px;
        border-radius: 14px;
        border: 2px solid #dadce0;
        background: #fff;
        cursor: pointer;
        transition: all .2s cubic-bezier(.34,1.56,.64,1);
        min-width: 72px;
        user-select: none;
    }
    .date-btn:hover { border-color: #1a73e8; background: #e8f0fe; transform: translateY(-2px); }
    .date-btn.active {
        border-color: #1a73e8;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        box-shadow: 0 6px 18px rgba(26,115,232,.35);
        transform: translateY(-3px);
    }
    .date-btn .day-name {
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .4px; color: #9aa0a6;
    }
    .date-btn .day-num {
        font-size: 1.4rem; font-weight: 800; color: #3c4043; line-height: 1.1; margin: 2px 0;
    }
    .date-btn .month { font-size: .68rem; color: #9aa0a6; }
    .date-btn.active .day-name,
    .date-btn.active .day-num,
    .date-btn.active .month { color: #fff; }
    .date-btn .slot-count {
        margin-top: 5px;
        background: #e8f0fe; color: #1a73e8;
        border-radius: 10px; padding: 1px 7px;
        font-size: .65rem; font-weight: 700;
    }
    .date-btn.active .slot-count { background: rgba(255,255,255,.25); color: #fff; }

    /* ===== SLOTS PANEL ===== */
    .slots-panel {
        background: #fff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
        animation: fadeUp .5s ease both;
        min-height: 220px;
    }
    .slots-panel-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 18px;
    }
    .slots-panel-header h5 {
        font-weight: 700; font-size: 1rem; color: #3c4043; margin: 0;
    }
    .slots-panel-header .selected-date-label {
        font-size: .8rem; color: #1a73e8; font-weight: 600;
        background: #e8f0fe; border-radius: 20px; padding: 3px 12px;
    }

    /* Slot nội dung mỗi ngày */
    .day-slots { display: none; }
    .day-slots.show { display: block; animation: fadeUp .3s ease both; }

    .slot-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 10px; }
    .slot-radio { display: none; }
    .slot-label {
        display: flex; flex-direction: column; align-items: center;
        border: 2px solid #dadce0;
        border-radius: 12px;
        padding: 10px 8px;
        cursor: pointer;
        transition: all .2s ease;
        background: #fff;
        text-align: center;
    }
    .slot-label:hover { border-color: #1a73e8; background: #e8f0fe; transform: translateY(-2px); }
    .slot-radio:checked + .slot-label {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 6px 16px rgba(26,115,232,.4);
        transform: translateY(-3px);
    }
    .slot-label .slot-time {
        font-size: 1.1rem; font-weight: 800; letter-spacing: .3px;
    }
    .slot-label .slot-remain {
        font-size: .68rem; margin-top: 3px; color: #6c757d;
        font-weight: 500;
    }
    .slot-radio:checked + .slot-label .slot-remain { color: rgba(255,255,255,.8); }

    .empty-slots {
        text-align: center; padding: 40px 20px; color: #9aa0a6;
    }
    .empty-slots i { font-size: 3rem; display: block; margin-bottom: 10px; }

    /* ===== BOOKING SUMMARY ===== */
    .booking-summary {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        border-radius: 16px;
        padding: 18px 20px;
        color: #fff;
        margin-top: 18px;
        display: none;
        animation: fadeUp .3s ease both;
    }
    .booking-summary.show { display: block; }
    .booking-summary h6 { font-weight: 700; margin-bottom: 12px; opacity: .8; font-size: .8rem; text-transform: uppercase; }
    .summary-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: .88rem; }
    .summary-row i { width: 18px; opacity: .75; }
    .summary-row span { opacity: .9; }
    .summary-row strong { opacity: 1; font-weight: 700; }

    /* ===== SUBMIT BUTTON ===== */
    .btn-confirm {
        display: block; width: 100%;
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: #fff; border: none; border-radius: 14px;
        padding: 14px 0; font-weight: 800; font-size: 1rem;
        letter-spacing: .3px; margin-top: 20px;
        transition: transform .15s, box-shadow .15s;
        cursor: pointer;
    }
    .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,115,232,.45); color:#fff; }
    .btn-confirm:disabled { opacity: .5; cursor: not-allowed; transform: none; }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

<div class="booking-wrap">

    {{-- ===== SIDEBAR: THÔNG TIN BÁC SĨ ===== --}}
    <div class="booking-sidebar">
        <div class="doc-card">
            <div class="doc-card-photo">
                @php $photoId = ($doctor->id % 70) + 1; $gender = ($doctor->id % 2 === 0) ? 'men' : 'women'; @endphp
                <img
                    src="https://randomuser.me/api/portraits/{{ $gender }}/{{ $photoId }}.jpg"
                    alt="{{ $doctor->full_name }}"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($doctor->full_name) }}&background=1a73e8&color=fff&size=300&bold=true'"
                >
                <div class="doc-card-photo-overlay"></div>
                <div class="doc-card-photo-name">
                    <h4>BS. {{ $doctor->full_name }}</h4>
                    <span>{{ $doctor->qualifications ?? 'Bác sĩ chuyên khoa' }}</span>
                </div>
            </div>
            <div class="doc-card-body">
                <div class="doc-stars mb-2">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    <span>4.5 ({{ rand(20,120) }} đánh giá)</span>
                </div>
                <div class="doc-info-row">
                    <i class="fas fa-tooth"></i>
                    <span>{{ $doctor->specialization->name ?? 'Chuyên khoa' }}</span>
                </div>
                <div class="doc-info-row">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $doctor->city->name ?? 'Chưa rõ' }}</span>
                </div>
                @if($doctor->phone_number)
                <div class="doc-info-row">
                    <i class="fas fa-phone-alt"></i>
                    <span>{{ $doctor->phone_number }}</span>
                </div>
                @endif
                @if($doctor->description)
                <div class="mt-2 pt-2" style="font-size:.8rem;color:#6c757d;line-height:1.5">
                    {{ Str::limit($doctor->description, 100) }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== MAIN: CHỌN LỊCH ===== --}}
    <div class="booking-main">

        @if($schedules->isEmpty())
            {{-- Empty --}}
            <div class="slots-panel">
                <div class="empty-slots">
                    <i class="far fa-calendar-times text-muted"></i>
                    <h5 class="font-weight-bold text-muted">Chưa có lịch làm việc</h5>
                    <p style="font-size:.85rem">Bác sĩ hiện chưa thiết lập lịch. Vui lòng quay lại sau!</p>
                    <a href="{{ route('patient.doctors') }}" class="btn btn-outline-primary btn-sm rounded-pill mt-2">
                        <i class="fas fa-arrow-left mr-1"></i> Chọn bác sĩ khác
                    </a>
                </div>
            </div>
        @else

        <form action="{{ route('patient.booking.store') }}" method="POST" id="bookingForm">
            @csrf

            {{-- ===== THANH CHỌN NGÀY ===== --}}
            <div class="date-bar-wrap">
                <div class="date-bar-title">
                    <i class="far fa-calendar-alt mr-1"></i> Chọn ngày khám
                </div>
                <div class="date-bar" id="dateBar">
                    @foreach($schedules as $i => $schedule)
                    @php
                        $carbon    = \Carbon\Carbon::parse($schedule->work_date);
                        $days_vi   = ['CN','T2','T3','T4','T5','T6','T7'];
                        $dayName   = $days_vi[$carbon->dayOfWeek];
                        $slotCount = $schedule->timeSlots->count();
                    @endphp
                    <div class="date-btn {{ $i === 0 ? 'active' : '' }}"
                         data-target="day-{{ $schedule->id }}"
                         data-label="{{ $dayName }}, {{ $carbon->format('d/m/Y') }}"
                         onclick="selectDate(this)">
                        <span class="day-name">{{ $dayName }}</span>
                        <span class="day-num">{{ $carbon->format('d') }}</span>
                        <span class="month">Th{{ $carbon->format('m') }}</span>
                        <span class="slot-count">{{ $slotCount }} ca</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ===== PANEL SLOT GIỜ ===== --}}
            <div class="slots-panel">
                <div class="slots-panel-header">
                    <h5><i class="far fa-clock mr-2 text-primary"></i>Chọn giờ khám</h5>
                    <span class="selected-date-label" id="selectedDateLabel">
                        {{ $days_vi[\Carbon\Carbon::parse($schedules->first()->work_date)->dayOfWeek] }},
                        {{ \Carbon\Carbon::parse($schedules->first()->work_date)->format('d/m/Y') }}
                    </span>
                </div>

                @foreach($schedules as $i => $schedule)
                <div class="day-slots {{ $i === 0 ? 'show' : '' }}" id="day-{{ $schedule->id }}">
                    @if($schedule->timeSlots->isEmpty())
                        <div class="empty-slots">
                            <i class="far fa-clock"></i>
                            <p>Không có ca trống trong ngày này.</p>
                        </div>
                    @else
                    <div class="slot-grid">
                        @foreach($schedule->timeSlots as $slot)
                        <div>
                            <input type="radio" name="slot_id" id="slot_{{ $slot->id }}" value="{{ $slot->id }}" class="slot-radio" onchange="updateSummary(this)">
                            <label for="slot_{{ $slot->id }}" class="slot-label">
                                <span class="slot-time">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</span>
                                <span class="slot-remain">
                                    {{ $slot->max_patient - $slot->current_patient }} chỗ còn
                                </span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- ===== BOOKING SUMMARY ===== --}}
            <div class="booking-summary" id="bookingSummary">
                <h6><i class="fas fa-receipt mr-1"></i> Thông tin đặt lịch</h6>
                <div class="summary-row">
                    <i class="fas fa-user-md"></i>
                    <span>Bác sĩ: <strong>BS. {{ $doctor->full_name }}</strong></span>
                </div>
                <div class="summary-row">
                    <i class="far fa-calendar-alt"></i>
                    <span>Ngày: <strong id="summaryDate">—</strong></span>
                </div>
                <div class="summary-row">
                    <i class="far fa-clock"></i>
                    <span>Giờ: <strong id="summaryTime">—</strong></span>
                </div>
            </div>

            {{-- ===== NÚT XÁC NHẬN ===== --}}
            <button type="submit" class="btn-confirm" id="btnConfirm" onsubmit="return confirm('Xác nhận đặt lịch?');" disabled>
                <i class="fas fa-check-circle mr-2"></i> Xác nhận đặt lịch
            </button>

        </form>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Khi bấm chọn ngày
    function selectDate(el) {
        // Bỏ active tất cả
        document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');

        // Ẩn tất cả slot panel
        document.querySelectorAll('.day-slots').forEach(p => p.classList.remove('show'));

        // Hiện panel của ngày được chọn
        const target = document.getElementById(el.dataset.target);
        if (target) target.classList.add('show');

        // Cập nhật label ngày
        document.getElementById('selectedDateLabel').textContent = el.dataset.label;

        // Reset summary khi đổi ngày
        document.querySelectorAll('.slot-radio').forEach(r => r.checked = false);
        hideSummary();
    }

    // Khi chọn 1 slot giờ
    function updateSummary(radio) {
        const label     = radio.nextElementSibling;
        const time      = label.querySelector('.slot-time').textContent.trim();
        const activeBtn = document.querySelector('.date-btn.active');
        const date      = activeBtn ? activeBtn.dataset.label : '—';

        document.getElementById('summaryDate').textContent = date;
        document.getElementById('summaryTime').textContent = time;
        document.getElementById('bookingSummary').classList.add('show');
        document.getElementById('btnConfirm').disabled = false;
    }

    function hideSummary() {
        document.getElementById('bookingSummary').classList.remove('show');
        document.getElementById('btnConfirm').disabled = true;
    }
</script>
@endpush
