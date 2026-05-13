<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cổng thông tin Bệnh nhân')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Tùy chỉnh màu sắc cho nhẹ nhàng, phù hợp với ngành y tế */
        .navbar-light .navbar-nav .nav-link { color: #0056b3; font-weight: 500; }
        .navbar-light .navbar-nav .nav-link.active { color: #007bff; font-weight: bold; border-bottom: 2px solid #007bff; }
    </style>
</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('patient.dashboard_patient') }}" class="navbar-brand">
                <i class="fas fa-hospital-user text-primary mr-2"></i>
                <span class="brand-text font-weight-bold text-primary">Phòng Khám 247</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('patient.dashboard_patient') }}" class="nav-link {{ request()->routeIs('patient.dashboard_patient') ? 'active' : '' }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('patient.doctors') }}" class="nav-link {{ request()->routeIs('patient.doctors*') ? 'active' : '' }}">Tìm Bác sĩ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('patient.appointments') }}" class="nav-link {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">Lịch sử khám</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Nội dung y tế</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name ?? 'Bệnh nhân' }}
                        </a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{route('patient.profile')}}" class="dropdown-item">Hồ sơ cá nhân</a></li>
                            <li><a href="#" class="dropdown-item">Thông báo</a></li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <h1 class="m-0">@yield('header_title')</h1>
            </div>
        </div>

        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="main-footer text-center">
        <strong>Copyright &copy; {{ date('Y') }} Phòng Khám 247.</strong> All rights reserved.
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
