<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- AdminLTE -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <!-- Left navbar -->
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link"
                   data-widget="pushmenu"
                   href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

        </ul>

        <!-- Right navbar -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown" id="notification-dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" id="notif-bell">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge" id="notif-badge" style="display:none;">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width:350px;max-height:500px;overflow-y:auto">
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                        <span class="dropdown-item-title font-weight-bold">Thông báo</span>
                        <form action="{{ route('notifications.markAllRead') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-link btn-sm p-0" style="font-size:11px">Đánh dấu đã đọc tất cả</button>
                        </form>
                    </div>
                    <div id="notif-list">
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>
            </li>

        </ul>

    </nav>

    <!-- SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Logo -->
        <a href="#" class="brand-link">

            <span class="brand-text font-weight-light">
                AdminLTE
            </span>

        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- User -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                <div class="image">

                    <img src="https://i.pravatar.cc/150"
                         class="img-circle elevation-2">

                </div>

                <div class="info">

                    <a href="#" class="d-block">
                        {{ auth()->user()->name }}
                    </a>

                </div>

            </div>

            <!-- Menu -->
            <nav class="mt-2">
                    @if(auth()->user()->role === 'admin')
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.accounts') }}"
                               class="nav-link {{ request()->routeIs('admin.accounts*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Tài khoản</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.doctors') }}"
                               class="nav-link {{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>Bác sĩ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.patients') }}"
                               class="nav-link {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hospital-user"></i>
                                <p>Bệnh nhân</p>
                            </a>
                        </li>

                    @endif

                </ul>

            </nav>

        </div>

    </aside>

    <!-- CONTENT -->
    <div class="content-wrapper">

        <!-- Header -->
        <section class="content-header">

            <div class="container-fluid">

                <h1>@yield('title')</h1>

            </div>

        </section>

        <!-- Main -->
        <section class="content">

            <div class="container-fluid">

                @yield('content')

            </div>

        </section>

    </div>

    <!-- FOOTER -->
    <footer class="main-footer">

        <strong>
            Copyright &copy; {{ date('Y') }}
        </strong>

    </footer>

</div>

<!-- Scripts -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
@yield('scripts')

<script>
// Load notifications
function loadNotifications() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {
            const unreadCount = data.filter(n => !n.read_at).length;
            const badge = document.getElementById('notif-badge');
            const list = document.getElementById('notif-list');
            
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }

            if (data.length === 0) {
                list.innerHTML = '<div class="text-center py-3 text-muted"><i class="far fa-bell-slash"></i><br>Không có thông báo</div>';
                return;
            }

            list.innerHTML = data.map(n => {
                const isUnread = !n.read_at;
                const bgClass = isUnread ? 'bg-light' : '';
                const data = n.data || {};
                const patientName = data.patient_name || 'N/A';
                const doctorName = data.doctor_name || '';
                const timeSlot = data.time_slot || '';
                const workDate = data.work_date ? new Date(data.work_date).toLocaleDateString('vi-VN') : '';
                
                let message = '';
                if (n.type === 'new_booking') {
                    message = `<strong>${patientName}</strong> đã đặt lịch khám${doctorName ? ' với BS. ' + doctorName : ''}`;
                }
                
                const time = new Date(n.created_at).toLocaleString('vi-VN');
                
                return `
                    <div class="dropdown-item ${bgClass}" style="white-space:normal;padding:10px 15px;border-bottom:1px solid #f0f0f0">
                        <div style="font-size:13px">${message}</div>
                        <small style="font-size:11px;color:#999">
                            <i class="far fa-calendar-alt"></i> ${workDate} • ${timeSlot}<br>
                            <i class="far fa-clock"></i> ${time}
                        </small>
                        ${isUnread ? `
                            <form action="/notifications/${n.id}/mark-read" method="POST" style="display:inline;margin-top:5px">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]')?.content || ''}">
                                <button type="submit" class="btn btn-link btn-sm p-0" style="font-size:11px;color:#007bff">Đánh dấu đã đọc</button>
                            </form>
                        ` : ''}
                    </div>
                `;
            }).join('');
        })
        .catch(err => {
            console.error('Error loading notifications:', err);
            document.getElementById('notif-list').innerHTML = '<div class="text-center py-3 text-danger">Lỗi tải thông báo</div>';
        });
}

// Load on page load
document.addEventListener('DOMContentLoaded', loadNotifications);

// Reload every 30 seconds
setInterval(loadNotifications, 30000);
</script>

</body>
</html>
