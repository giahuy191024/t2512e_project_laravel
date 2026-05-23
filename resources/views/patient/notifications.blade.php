@extends('layouts.patient')
@section('title', 'Thông báo của tôi')

@push('styles')
<style>
    .notif-hero {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 60%, #01579b 100%);
        border-radius: 16px; padding: 28px 24px; color: #fff;
        margin-bottom: 24px; position: relative; overflow: hidden;
        animation: fadeUp .5s ease both;
    }
    .notif-hero::after {
        content: '\f0f3';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        font-size: 100px; position: absolute;
        right: -5px; bottom: -15px; opacity: .07; color: #fff;
    }
    .notif-hero h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 4px; }
    .notif-hero p { opacity: .8; margin: 0; font-size: .9rem; }

    .notif-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        margin-bottom: 12px; overflow: hidden;
        border-left: 4px solid transparent;
        animation: fadeUp .4s ease both;
        transition: transform .2s, box-shadow .2s;
    }
    .notif-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
    .notif-card.unread { border-left-color: #1a73e8; background: #f8fbff; }
    .notif-card.read { border-left-color: #dadce0; opacity: .8; }

    .notif-card-inner {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 16px 18px;
    }
    .notif-icon {
        width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1rem;
    }
    .notif-icon.new_booking { background: #e8f0fe; color: #1a73e8; }
    .notif-icon.booking_cancelled { background: #fee2e2; color: #dc2626; }
    .notif-icon.booking_transferred { background: #e6faf8; color: #2ec4b6; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-message { font-size: .88rem; color: #3c4043; line-height: 1.5; margin-bottom: 4px; }
    .notif-message strong { font-weight: 700; }
    .notif-time { font-size: .72rem; color: #9aa0a6; }
    .notif-time i { margin-right: 3px; }

    .notif-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #1a73e8; flex-shrink: 0; margin-top: 6px;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.5); opacity: .6; } }

    .empty-state {
        text-align: center; padding: 70px 20px;
        background: #fff; border-radius: 16px;
        box-shadow: 0 2px 14px rgba(0,0,0,.06);
    }
    .empty-state i { font-size: 56px; color: #dadce0; display: block; margin-bottom: 14px; }
    .empty-state h5 { color: #5f6368; font-weight: 700; }
    .empty-state p { color: #9aa0a6; font-size: .88rem; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="notif-hero">
    <h2><i class="far fa-bell mr-2"></i> Thông báo</h2>
    <p>Cập nhật các thông tin về lịch khám của bạn</p>
</div>

@if($notifications->isEmpty())
    <div class="empty-state">
        <i class="far fa-bell-slash"></i>
        <h5>Không có thông báo nào</h5>
        <p>Bạn sẽ nhận được thông báo khi có lịch hẹn mới hoặc có thay đổi.</p>
        <a href="{{ route('patient.doctors') }}" class="btn btn-primary rounded-pill mt-2">
            <i class="fas fa-user-md mr-1"></i> Đặt lịch ngay
        </a>
    </div>
@else
    @foreach($notifications as $notif)
    @php
        $data = $notif->data ?? [];
        $isUnread = is_null($notif->read_at);
        $iconMap = [
            'new_booking' => 'fa-calendar-check',
            'booking_cancelled' => 'fa-calendar-times',
            'booking_transferred' => 'fa-exchange-alt',
        ];
        $icon = $iconMap[$notif->type] ?? 'fa-bell';
        $message = '';

        if ($notif->type === 'new_booking') {
            $message = 'Bạn đã đặt lịch khám thành công.';
            if (!empty($data['doctor_name'])) {
                $message = 'Bạn đã đặt lịch khám với <strong>BS. ' . e($data['doctor_name']) . '</strong>.';
            }
        } elseif ($notif->type === 'booking_cancelled') {
            $doctorName = $data['doctor_name'] ?? 'Bác sĩ';
            $reason = $data['cancel_reason'] ?? '';
            $message = 'Lịch khám với <strong>BS. ' . e($doctorName) . '</strong> đã bị huỷ.';
            if ($reason) {
                $message .= '<br><span style="color:#dc2626">Lý do: ' . e($reason) . '</span>';
            }
        } elseif ($notif->type === 'booking_transferred') {
            $newDoctor = $data['new_doctor_name'] ?? 'bác sĩ mới';
            $note = $data['note'] ?? '';
            $message = 'Lịch khám của bạn đã được chuyển sang <strong>BS. ' . e($newDoctor) . '</strong>.';
            if ($note) {
                $message .= '<br><span style="color:#2ec4b6">' . e($note) . '</span>';
            }
        }
    @endphp
    <div class="notif-card {{ $isUnread ? 'unread' : 'read' }}">
        <div class="notif-card-inner">
            <div class="notif-icon {{ $notif->type }}">
                <i class="fas {{ $icon }}"></i>
            </div>
            <div class="notif-body">
                <div class="notif-message">{!! $message !!}</div>
                <div class="notif-time">
                    <i class="far fa-clock"></i>{{ $notif->created_at->diffForHumans() }}
                    @if(!empty($data['work_date']))
                        &nbsp;•&nbsp; <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($data['work_date'])->format('d/m/Y') }}
                    @endif
                    @if(!empty($data['time_slot']))
                        &nbsp;•&nbsp; <i class="far fa-clock"></i> {{ $data['time_slot'] }}
                    @endif
                </div>
            </div>
            @if($isUnread)
                <div class="notif-dot"></div>
            @endif
        </div>
    </div>
    @endforeach
@endif
@endsection
