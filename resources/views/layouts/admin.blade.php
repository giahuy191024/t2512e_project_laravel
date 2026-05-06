<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>

<!-- 1. SIDEBAR (Bên trái) -->
<aside class="admin-sidebar">
    <!-- Logo -->
    <div class="sidebar-brand">
        <div class="logo-icon">A</div>
        <div>
            Adminator<br>
            <small class="text-muted" style="font-size: 0.65rem; font-weight: normal;">v4.1.2 preview</small>
        </div>
    </div>

    <!-- Menu -->
    <!-- Menu -->
    <div class="sidebar-menu">
        <div class="menu-category">Workspace</div>
        <a href="/dashboard" class="menu-item active"><i class="fa-solid fa-house"></i> Dashboard</a>

        @if(auth()->user()->role === 'admin')
            <!-- MENU CHỈ HIỆN CHO ADMIN -->
            <div class="menu-category">Management</div>
            <a href="{{ route('admin.accounts') }}" class="menu-item"><i class="fa-solid fa-users"></i> Tài khoản</a>
            <a href="{{ route('admin.doctors') }}" class="menu-item"><i class="fa-solid fa-user-doctor"></i> Bác sĩ</a>
            <a href="{{ route('admin.patients') }}" class="menu-item"><i class="fa-solid fa-hospital-user"></i> Bệnh nhân</a>

            <div class="menu-category">Settings</div>
            <a href="{{ route('admin.cities') }}" class="menu-item"><i class="fa-solid fa-city"></i> Thành phố</a>
            <a href="{{ route('admin.contents') }}" class="menu-item"><i class="fa-solid fa-file-lines"></i> Nội dung</a>

        @elseif(auth()->user()->role === 'doctor')
            <!-- MENU CHỈ HIỆN CHO BÁC SĨ -->
            <div class="menu-category">Medical</div>
            <a href="#" class="menu-item"><i class="fa-solid fa-calendar-check"></i> Lịch khám của tôi</a>
            <a href="#" class="menu-item"><i class="fa-solid fa-pills"></i> Đơn thuốc</a>

        @else
            <!-- MENU CHỈ HIỆN CHO BỆNH NHÂN -->
            <div class="menu-category">Dịch vụ</div>
            <a href="/appointment" class="menu-item"><i class="fa-solid fa-notes-medical"></i> Đặt lịch khám</a>
            <a href="#" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử khám</a>
        @endif
    </div>

    <!-- User Profile Bottom -->
    <div class="sidebar-user">
        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: bold;">
            <div>
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
        </div>
        <div style="line-height: 1.2;">
            <div class="text-light" style="font-size: 0.9rem; font-weight: 600;"><div>
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div></div>
            <small class="text-muted" style="font-size: 0.75rem;">admin</small>
        </div>
    </div>
</aside>

<!-- 2. HEADER (Bên trên) -->
<header class="admin-header">
    <div class="header-left">
        <p class="breadcrumb mb-0">Workspace <i class="fa-solid fa-chevron-right mx-2" style="font-size: 0.6rem;"></i> <span class="text-white">Dashboard</span></p>
    </div>

    <div class="header-right d-flex align-items-center">
        <!-- Ô Search -->
        <div class="search-box me-3">
            <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
            <input type="text" placeholder="Search..." style="background: transparent; border: none; color: white; outline: none; width: 180px;">
        </div>

        <!-- Các Icon Thông Báo -->
        <div class="header-icon me-3"><i class="fa-regular fa-bell"></i><span class="badge bg-danger">3</span></div>
        <div class="header-icon me-3"><i class="fa-regular fa-envelope"></i><span class="badge bg-info">3</span></div>
        <div class="header-icon me-3"><i class="fa-solid fa-sun"></i></div>

        <!-- Avatar User -->
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: bold;">
            {{ substr(auth()->user()->name, 0, 2) }}
        </div>

        <!-- Nút Đăng Xuất -->
        <form action="/logout" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 20px; padding: 4px 15px;">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </button>
        </form>
    </div>
</header>

<!-- 3. MAIN CONTENT (Giữa) -->
<main class="admin-main">
    <div class="admin-content">
        @yield('content')
    </div>

    <!-- 4. FOOTER (Dưới cùng) -->
    <footer class="admin-footer">
        <div>&copy; {{ date('Y') }} Adminator. All rights reserved.</div>
        <div>Designed for Laravel</div>
    </footer>
</main>

</body>
</html>
