@extends('layouts.admin')

@section('content')

    @if(auth()->user()->role === 'admin')
        <!-- ========================================== -->
        <!-- GIAO DIỆN DÀNH CHO ADMIN (Mẫu Adminator)   -->
        <!-- ========================================== -->
        <div class="text-muted mb-2" style="font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase;">
            {{ now()->format('l &bull; M j &bull; Y') }}
        </div>

        <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">
            Welcome back, <span style="color: #3b82f6;">{{ explode(' ', auth()->user()->name)[0] }}</span>
        </h1>

        <p class="text-muted w-50 mb-5" style="font-size: 0.95rem; line-height: 1.6;">
            Total visits are <span class="text-success">+10%</span> week over week, unique visitors steady, and bounce rate holding at 33%. Two new regions came online overnight.
        </p>

        <div class="row">
            <!-- Tạm thời để trống -->
        </div>

    @elseif(auth()->user()->role === 'doctor')
        <!-- ========================================== -->
        <!-- GIAO DIỆN DÀNH CHO BÁC SĨ                  -->
        <!-- ========================================== -->
        <h1 class="fw-bold mb-3">Khu vực làm việc của Bác sĩ</h1>
        <p class="text-muted">Ông có 5 lịch khám đang chờ hôm nay.</p>

    @else
        <!-- ========================================== -->
        <!-- GIAO DIỆN DÀNH CHO BỆNH NHÂN               -->
        <!-- ========================================== -->
        <h1 class="fw-bold mb-3">Xin chào, {{ auth()->user()->name }}</h1>
        <p class="text-muted">Ông muốn đặt lịch khám bệnh hôm nay chứ?</p>
        <a href="/appointment" class="btn btn-primary mt-3">Đặt lịch ngay</a>
    @endif

@endsection
