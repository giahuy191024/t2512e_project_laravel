<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- AdminLTE -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                </a>
            </li>

            <li class="nav-item">
                <form action="/logout" method="POST">
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
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @if(auth()->user()->role === 'doctor')
                    <li class="nav-item">
                        <a href="{{route('doctor.bookings.index')}}" class="nav-link {{ request()->routeIs('doctor.bookings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Lịch khám bệnh nhân</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('doctor.schedules.index') }}" class="nav-link {{ request()->routeIs('doctor.schedules*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>Đăng ký giờ làm</p>
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

</body>
</html>
