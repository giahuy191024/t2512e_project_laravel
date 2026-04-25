<!DOCTYPE html>
<html>
<head>
    <title>Đặt lịch khám</title>
    <link rel="stylesheet" href="{{asset('css/appointment.css')}}">
</head>
<body>
<form action="/logout" method="POST">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
<h2>Đăng ký lịch khám</h2>

@if(session('success'))
    <p style="color: green">
        {{ session('success') }}
    </p>
@endif

@if(session('error'))
    <p style="color: red">
        {{ session('error') }}
    </p>
@endif

<form action="/appointment" method="POST">
    @csrf

    <input
        type="text"
        name="full_name"
        value="{{ Auth::user()->name }}"
        readonly
    >

    <br><br>

    <input
        type="email"
        name="email"
        value="{{ Auth::user()->email }}"
        readonly
    >

    <br><br>

    <input
        type="text"
        name="phone"
        placeholder="Số điện thoại"
        required
    >
    <div>
        <label>Loại khám</label>
        <select name="service_type" id="service_type" required>
            <option value="">-- Chọn loại khám --</option>
            <option value="regular">Khám thường</option>
            <option value="specialist">Khám chuyên gia</option>
        </select>
    </div>

    <br>

    <div id="doctor_box" style="display: none;">
        <label>Chọn bác sĩ</label>
        <select name="doctor_name">
            <option value="">-- Chọn bác sĩ chuyên gia --</option>
            <option value="BS Trần Văn A">BS Trần Văn A</option>
            <option value="BS Nguyễn Thị B">BS Nguyễn Thị B</option>
            <option value="BS Lê Văn C">BS Lê Văn C</option>
        </select>
    </div>
    <br><br>

    <select name="department" required>
        <option value="">Chọn chuyên khoa</option>
        <option value="tim_mach">Tim mạch</option>
        <option value="noi_tiet">Nội tiết</option>
        <option value="da_lieu">Da liễu</option>
    </select>

    <br><br>

    <input
        type="date"
        name="appointment_date"
        required
    >

    <br><br>

    <select name="time_slot" required>
        <option value="">Chọn khung giờ</option>
        <option value="08:00">08:00</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
    </select>

    <br><br>

    <textarea
        name="note"
        placeholder="Ghi chú"
    ></textarea>

    <br><br>

    <button type="submit">
        Xác nhận đặt lịch
    </button>

</form>
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
