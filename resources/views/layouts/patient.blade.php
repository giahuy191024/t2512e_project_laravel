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

        /* ===== GLOBAL AD SIDEBAR LAYOUT ===== */
        body { background: #f0f4f8 !important; }
        .page-with-ads {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }
        .ad-sidebar {
            width: 170px;
            flex-shrink: 0;
        }
        .ad-sidebar.hidden { display: none; }
        .main-content-col { flex: 1; min-width: 0; }

        /* Ad card style */
        .ad-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            margin-bottom: 16px;
            border: none;
            animation: fadeAd .5s ease both;
        }
        .ad-card-label {
            font-size: .65rem;
            color: #9aa0a6;
            text-align: right;
            padding: 4px 10px 0;
            letter-spacing: .5px;
        }
        .ad-card-body { padding: 14px 14px 16px; text-align: center; }
        .ad-card-icon { font-size: 2.2rem; margin-bottom: 8px; display: block; }
        .ad-card-title { font-weight: 700; font-size: .85rem; color: #3c4043; margin-bottom: 4px; }
        .ad-card-desc  { font-size: .72rem; color: #6c757d; margin-bottom: 10px; line-height: 1.4; }
        .ad-card-btn {
            display: block;
            border-radius: 8px;
            padding: 6px 0;
            font-size: .75rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
        }
        .ad-card-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.15); text-decoration: none; }
        .ad-card-img { width: 100%; height: 90px; object-fit: cover; }

        @keyframes fadeAd {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .ad-sidebar-right .ad-card { animation-name: fadeAdRight; }
        @keyframes fadeAdRight {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Responsive: ẩn sidebar ads trên màn nhỏ */
        @media (max-width: 991px) {
            .ad-sidebar { display: none !important; }
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('patient.dashboard_patient') }}" class="navbar-brand">
                <i class="fas fa-hospital-user text-primary mr-2"></i>
                <span class="brand-text font-weight-bold text-primary">Mediaconnect</span>
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
            <div class="container-fluid px-3 px-lg-4">
                <div class="page-with-ads">

                    {{-- LEFT ADS --}}
                    <div class="ad-sidebar ad-sidebar-left" id="adLeft">
                        @stack('left-ad')
                    </div>

                    {{-- MAIN CONTENT --}}
                    <div class="main-content-col">
                        @yield('content')
                    </div>

                    {{-- RIGHT ADS --}}
                    <div class="ad-sidebar ad-sidebar-right" id="adRight">
                        @stack('right-ad')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer text-center">
        <strong>Copyright &copy; {{ date('Y') }} Mediaconnect.</strong> All rights reserved.
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    // Ẩn cột ad nếu không có nội dung
    ['adLeft','adRight'].forEach(function(id){
        var el = document.getElementById(id);
        if(el && !el.innerHTML.trim()) el.classList.add('hidden');
    });
</script>
@stack('scripts')
</body>
</html>
