<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lịch khám bệnh</title>
    <style>
        /* Thiết lập chung */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Khung chứa Form */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        h2 {
            color: #1a73e8;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        /* Nút đăng xuất góc trên */
        .logout-form {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .btn-logout {
            background: none;
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Định dạng các ô nhập liệu */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Giúp padding không làm tràn khung */
            font-size: 14px;
        }

        input[readonly] {
            background-color: #f9f9f9;
            color: #777;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        /* Nút xác nhận */
        .btn-submit {
            width: 100%;
            background-color: #1a73e8;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #1557b0;
        }

        /* Thông báo */
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <form action="/logout" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="btn-logout">Đăng xuất</button>
    </form>

    <h2>Đăng ký lịch khám</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form action="/appointment" method="POST">
        @csrf

        <div class="form-group">
            <label>Họ và tên bệnh nhân</label>
            <input type="text" name="full_name" value="{{$user->name}}" readonly>
        </div>

        <div class="form-group">
            <label>Email liên hệ</label>
            <input type="email" name="email" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label>Số điện thoại *</label>
            <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="form-group">
            <label>Loại hình khám</label>
            <select name="appointment_type" id="service_type" required>
                <option value="">-- Chọn loại khám --</option>
                <option value="regular">Khám thường</option>
                <option value="specialist">Khám chuyên gia</option>
            </select>
        </div>
        <div class="form-group" id="doctor_box" style="display: none;">
            <label style="color: #1a73e8;">Bác sĩ chuyên gia</label>
            <select name="doctor_id">
                <option value="">-- Chọn bác sĩ --</option>
                <option value="1">BS Trần Văn A</option>
                <option value="2">BS Nguyễn Thị B</option>
            </select>
        </div>

        <div class="form-group">
            <label>Chuyên khoa</label>
            <select name="department" required>
                <option value="">-- Chọn chuyên khoa --</option>
                <option value="tim_mach">Tim mạch</option>
                <option value="noi_tiet">Nội tiết</option>
                <option value="da_lieu">Da liễu</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ngày hẹn khám</label>
            <input type="date" name="appointment_date" required>
        </div>

        <div class="form-group">
            <label>Khung giờ</label>
            <select name="time_slot" required>
                <option value="">-- Chọn giờ --</option>
                <option value="1">08:00 - 09:00</option>
                <option value="2">09:00 - 10:00</option>
                <option value="3">10:00 - 11:00</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ghi chú thêm</label>
            <textarea name="note" placeholder="Triệu chứng hoặc yêu cầu đặc biệt..."></textarea>
        </div>

        <button type="submit" class="btn-submit">Xác nhận đặt lịch ngay</button>
    </form>
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
