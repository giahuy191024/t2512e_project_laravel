@extends('layouts.main')

@section('title', 'Danh sách lịch khám')

@section('content')
<section class="section">
    <h2 class="section-title">Danh Sách Lịch Khám</h2>
    <p class="section-subtitle">Dữ liệu được lấy trực tiếp từ database bảng appointments.</p>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="/appointment" class="btn-cta" style="padding: 10px 20px; border-radius: 8px;">
            + Đăng ký lịch mới
        </a>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
        <table style="width: 100%; border-collapse: collapse; min-width: 980px;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Họ tên</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Điện thoại</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Email</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Chuyên khoa</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Loại khám</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Ngày khám</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Giờ</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Bác sĩ</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->full_name }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->phone }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->email }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->department }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->service_type }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->appointment_date }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->time_slot }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->doctor_name }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">{{ $appointment->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding: 18px; text-align: center; color: #64748b;">
                            Chưa có lịch khám nào trong hệ thống.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
