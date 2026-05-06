<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Welcome {{auth()->user()->name}}</h1>
        @if(auth()->user()->role === 'admin')
            <div class="admin-section">
                <h3>Bang dieu khien Admin</h3>
            </div>
        @elseif(auth()->user()->role === 'doctor')
            <!-- Nội dung dành cho Bác sĩ -->
            <div class="doctor-section">
                <h3>Khu vực Bác sĩ</h3>
                <p>Xem danh sách lịch khám hôm nay.</p>
                <a href="/doctor/schedule">Xem lịch hẹn</a>
            </div>

        @else
            <!-- Mặc định là Patient -->
            <div class="patient-section">
                <h3>Khu vực Bệnh nhân</h3>
                <p>Ông muốn đặt lịch khám hôm nay không?</p>
                <a href="/appointment">Đặt lịch hẹn ngay</a>
            </div>
        @endif
    </div>
</body>
</html>
