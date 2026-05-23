@extends('layouts.patient')
@section('title', 'Thông báo')

@push('styles')
    <style>
        .notif-hero {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            border-radius: 16px;
            padding: 32px 28px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .notif-hero::before {
            content: '\f0f3';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 140px;
            position: absolute;
            right: -10px; top: -20px;
            opacity: .08; color: #fff;
        }
        .notif-hero h2 { font-size: 1.7rem; font-weight: 800; margin-bottom: 4px; }
        .notif-hero p { opacity: .85; margin: 0; }

        .notif-item {
            background: #fff;
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 12px;
            display: flex; align-items: flex-start; gap: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            border-left: 4px solid #1a73e8;
            transition: transform .2s, box-shadow .2s;
        }
        .notif-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0,0,0,.08);
        }
        .notif-icon {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: #e8f0fe; color: #1a73e8;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }
        .notif-body { flex: 1; }
        .notif-title { font-weight: 700; font-size: .95rem; color: #3c4043; margin-bottom: 4px; }
        .notif-message { font-size: .85rem; color: #5f6368; line-height: 1.5; }
        .notif-time { font-size: .72rem; color: #9aa0a6; margin-top: 6px; }
        .notif-time i { margin-right: 4px; }

        .empty-notif {
            background: #fff;
            border-radius: 16px;
            padding: 80px 20px;
            text-align: center;
            box-shadow: 0 2px 14px rgba(0,0,0,.05);
        }
        .empty-notif i {
            font-size: 70px; color: #dadce0;
            display: block; margin-bottom: 16px;
        }
        .empty-notif h5 { color: #5f6368; font-weight: 700; }
        .empty-notif p { color: #9aa0a6; font-size: .9rem; }
    </style>
@endpush

@section('content')

    <div class="notif-hero">
        <h2><i class="far fa-bell mr-2"></i> Thông báo</h2>
        <p>Cập nhật lịch hẹn, kết quả khám và thông tin mới nhất từ phòng khám</p>
    </div>

    @if($notifications->isEmpty())
        <div class="empty-notif">
            <i class="far fa-bell-slash"></i>
            <h5>Không có thông báo nào</h5>
            <p>Khi có lịch hẹn mới hoặc cập nhật, thông báo sẽ hiện ở đây.</p>
        </div>
    @else
        @foreach($notifications as $notif)
            <div class="notif-item">
                <div class="notif-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="notif-body">
                    <div class="notif-title">{{ $notif->type ?? 'Thông báo' }}</div>
                    <div class="notif-message">{{ $notif->message }}</div>
                    <div class="notif-time">
                        <i class="far fa-clock"></i>{{ $notif->created_at?->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
