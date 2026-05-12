@extends('layouts.main')

@section('title', 'Đặt khám - SmileDental')

@section('content')
<section class="booking-page">
    <div class="booking-wrapper">
        <div class="booking-card">
            <div class="booking-head">
                <div>
                    <p class="booking-kicker">Đặt khám trực tuyến</p>
                    <h1>Đặt lịch khám với bác sĩ nhanh chóng</h1>
                    <p class="booking-desc">Giữ nguyên thông tin khám như trước, nay hiển thị dưới dạng trang riêng để dễ điền và theo dõi hơn.</p>
                </div>
                <a href="/" class="booking-back"><i class="fas fa-arrow-left"></i> Về trang chủ</a>
            </div>

            @if(session('success'))
                <div class="booking-alert success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="booking-alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="booking-doctor">
                <img src="{{ old('doctor_image', $doctorImage ?: '/img/image-1778161714802.jpeg') }}" alt="Bác sĩ" class="booking-doctor-image" />
                <div>
                    <h3>{{ old('doctor_name', $doctorName ?: 'Bác sĩ tư vấn') }}</h3>
                    <p><i class="fas fa-clinic-medical"></i> {{ $clinicName ?: 'Nha Khoa Trẻ' }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $doctorAddress ?: 'Số 38 Nguy Như Kon Tum, Phường Nhân Chính, Quận Thanh Xuân, TP Hà Nội' }}</p>
                </div>
            </div>

            <form action="{{ route('appointment.book.store') }}" method="POST" class="booking-form">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ old('doctor_id', $doctorId) }}">
                <input type="hidden" name="doctor_name" value="{{ old('doctor_name', $doctorName ?: 'Bác sĩ tư vấn') }}">
                <input type="hidden" name="doctor_image" value="{{ old('doctor_image', $doctorImage) }}">

                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Họ tên bệnh nhân (bắt buộc)</label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" placeholder="Họ tên bệnh nhân" required />
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Số điện thoại liên hệ (bắt buộc)</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại liên hệ" required />
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Địa chỉ email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Địa chỉ email" />
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-birthday-cake"></i> Năm sinh (bắt buộc)</label>
                        <input type="number" name="birth_year" value="{{ old('birth_year') }}" placeholder="Năm sinh" min="1900" max="{{ date('Y') }}" required />
                    </div>

                    <div class="form-group form-group--full">
                        <label><i class="fas fa-calendar"></i> Ngày khám</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required />
                    </div>

                    <div class="form-group form-group--full">
                        <label><i class="fas fa-stethoscope"></i> Lý do khám</label>
                        <textarea name="reason" placeholder="Lý do khám" rows="4">{{ old('reason') }}</textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label>Bạn biết đến Nha Khoa Trẻ từ đâu?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="source" value="Google" {{ old('source') === 'Google' ? 'checked' : '' }} /> Google</label>
                            <label><input type="radio" name="source" value="Facebook" {{ old('source') === 'Facebook' ? 'checked' : '' }} /> Facebook</label>
                            <label><input type="radio" name="source" value="TikTok" {{ old('source') === 'TikTok' ? 'checked' : '' }} /> TikTok</label>
                            <label><input type="radio" name="source" value="Other" {{ old('source') === 'Other' ? 'checked' : '' }} /> Khác</label>
                        </div>
                    </div>
                </div>

                <p class="form-note">Quý khách vui lòng điền đầy đủ thông tin trên</p>
                <button type="submit" class="btn-submit">Xác nhận đặt khám</button>
            </form>
        </div>
    </div>
</section>

<style>
.booking-page {
    background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 45%);
    padding: 36px 16px 64px;
}

.booking-wrapper {
    max-width: 860px;
    margin: 0 auto;
}

.booking-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 16px 36px rgba(14, 165, 233, 0.12);
}

.booking-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: flex-start;
    margin-bottom: 20px;
}

.booking-kicker {
    display: inline-block;
    font-size: 12px;
    color: #0369a1;
    background: #e0f2fe;
    padding: 6px 10px;
    border-radius: 999px;
    margin-bottom: 10px;
    font-weight: 700;
}

.booking-head h1 {
    font-size: 30px;
    line-height: 1.25;
    margin-bottom: 8px;
}

.booking-desc {
    color: #64748b;
}

.booking-back {
    text-decoration: none;
    color: #0369a1;
    font-weight: 600;
    white-space: nowrap;
}

.booking-doctor {
    display: flex;
    gap: 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 18px;
}

.booking-doctor-image {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}

.booking-doctor h3 {
    margin: 0 0 6px;
}

.booking-doctor p {
    color: #64748b;
    margin: 2px 0;
    font-size: 14px;
}

.booking-alert {
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 14px;
}

.booking-alert.success {
    background: #ecfdf3;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.booking-alert.error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.booking-alert ul {
    margin: 0;
    padding-left: 18px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.form-group--full {
    grid-column: 1 / -1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #1e293b;
}

.form-group input,
.form-group textarea {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 11px 12px;
    font-size: 14px;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
}

.radio-group {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 8px;
}

.radio-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 9px 10px;
    margin: 0;
    font-weight: 500;
}

.form-note {
    text-align: center;
    color: #64748b;
    font-size: 12px;
    margin: 14px 0;
}

.btn-submit {
    width: 100%;
    border: none;
    border-radius: 10px;
    padding: 12px 14px;
    color: #fff;
    background: linear-gradient(135deg, #f59e0b, #ea580c);
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(234, 88, 12, 0.28);
}

@media (max-width: 768px) {
    .booking-card {
        padding: 18px;
    }

    .booking-head {
        flex-direction: column;
    }

    .booking-head h1 {
        font-size: 24px;
    }

    .booking-doctor {
        flex-direction: column;
        text-align: center;
    }

    .booking-doctor-image {
        margin: 0 auto;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .radio-group {
        grid-template-columns: 1fr 1fr;
    }
}
</style>
@endsection
