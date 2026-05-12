<!DOCTYPE html>
<html>
<head>
    <title>Đặt lịch hẹn</title>
    <link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
</head>
<body class="appointment-page">
<div class="appointment-shell">
    <div class="appointment-card">
        <div class="appointment-card__header">
            <div>
                <p class="label-pill">Đặt lịch hẹn</p>
                <h1>Đăng ký khám nha khoa nhanh chóng</h1>
                <p class="card-description">Nha Khoa Smile sẽ liên hệ lại trong vòng 3 phút. Hỗ trợ đặt lịch từ 08h-22h mỗi ngày, kể cả cuối tuần.</p>
            </div>
            <a href="/" class="card-close" aria-label="Đóng form">×</a>
        </div>

        <div class="appointment-banner">
            <div>
                <span class="badge-soft">Ưu tiên sớm</span>
                <p>Chọn ngày giờ, dịch vụ và bác sĩ phù hợp. Chúng tôi sẽ xác nhận nhanh nhất.</p>
            </div>
            <div class="appointment-hotline">
                <span>Hotline</span>
                <strong>1900 1234</strong>
            </div>
        </div>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/appointment" method="POST" class="appointment-form">
            @csrf

            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Giới tính</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="gender" value="Anh" {{ old('gender', 'Anh') === 'Anh' ? 'checked' : '' }}>
                            <span>Anh</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="gender" value="Chị" {{ old('gender') === 'Chị' ? 'checked' : '' }}>
                            <span>Chị</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="full_name" value="{{ $user->name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại" required>
                </div>

                <div class="form-group">
                    <label>Chuyên khoa</label>
                    <select name="department" required>
                        <option value="">Chọn chuyên khoa</option>
                        <option value="tim_mach" {{ old('department') === 'tim_mach' ? 'selected' : '' }}>Tim mạch</option>
                        <option value="noi_tiet" {{ old('department') === 'noi_tiet' ? 'selected' : '' }}>Nội tiết</option>
                        <option value="da_lieu" {{ old('department') === 'da_lieu' ? 'selected' : '' }}>Da liễu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Loại khám</label>
                    <select name="service_type" id="service_type" required>
                        <option value="">Chọn loại khám</option>
                        <option value="regular" {{ old('service_type') === 'regular' ? 'selected' : '' }}>Khám thường</option>
                        <option value="specialist" {{ old('service_type') === 'specialist' ? 'selected' : '' }}>Khám chuyên gia</option>
                    </select>
                </div>

                <div class="form-group doctor-group" id="doctor_box" style="display: {{ old('service_type') === 'specialist' ? 'block' : 'none' }};">
                    <label>Chọn bác sĩ</label>
                    <select name="doctor_name">
                        <option value="">Chọn bác sĩ chuyên gia</option>
                        <option value="BS Trần Văn A" {{ old('doctor_name') === 'BS Trần Văn A' ? 'selected' : '' }}>BS Trần Văn A</option>
                        <option value="BS Nguyễn Thị B" {{ old('doctor_name') === 'BS Nguyễn Thị B' ? 'selected' : '' }}>BS Nguyễn Thị B</option>
                        <option value="BS Lê Văn C" {{ old('doctor_name') === 'BS Lê Văn C' ? 'selected' : '' }}>BS Lê Văn C</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày khám</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                </div>

                <div class="form-group">
                    <label>Khung giờ</label>
                    <select name="time_slot" required>
                        <option value="">Chọn khung giờ</option>
                        <option value="08:00" {{ old('time_slot') === '08:00' ? 'selected' : '' }}>08:00</option>
                        <option value="09:00" {{ old('time_slot') === '09:00' ? 'selected' : '' }}>09:00</option>
                        <option value="10:00" {{ old('time_slot') === '10:00' ? 'selected' : '' }}>10:00</option>
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Ghi chú</label>
                <textarea name="note" placeholder="Nhập yêu cầu thêm...">{{ old('note') }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Xác nhận đặt lịch</button>
        </form>
    </div>
</div>

<script>
    const serviceType = document.getElementById('service_type');
    const doctorBox = document.getElementById('doctor_box');

    serviceType.addEventListener('change', function () {
        if (this.value === 'specialist') {
            doctorBox.style.display = 'block';
        } else {
            doctorBox.style.display = 'none';
        }
    });
</script>
</body>
</html> 
