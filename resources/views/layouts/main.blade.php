<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmileDental - Nha Khoa Uy Tín')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0ea5e9;
            --secondary-color: #06b6d4;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 88px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-scrolled {
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            max-width: none;
            border-radius: 0;
            background: rgba(255, 255, 255, 0.96) !important;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.10);
            border: none;
        }

        .navbar-scrolled .navbar-container {
            height: 70px;
            padding: 0 20px;
        }

        .navbar-scrolled .logo,
        .navbar-scrolled .nav-menu a,
        .navbar-scrolled .btn-login,
        .navbar-scrolled .btn-register {
            color: var(--text-dark) !important;
        }

        .navbar-scrolled .nav-menu a:hover,
        .navbar-scrolled .nav-menu a.active {
            color: var(--primary-color) !important;
            border-bottom-color: var(--primary-color) !important;
        }

        .navbar-scrolled .btn-login {
            color: var(--text-dark) !important;
            border-color: rgba(31, 41, 55, 0.16);
            background: rgba(255, 255, 255, 0.86);
        }

        .navbar-scrolled .btn-register {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white !important;
            border-color: transparent;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 28px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 18px;
            flex: 1;
            margin-left: 50px;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 15px;
            line-height: 1.3;
            letter-spacing: 0.1px;
            transition: color 0.3s ease;
            padding: 8px 10px;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }


        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-login,
        .btn-register {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            line-height: 1.2;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .btn-login {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            background: transparent;
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 182, 212, 0.4);
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 250px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            border: 1px solid #e5e7eb;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li {
            list-style: none;
            border-bottom: 1px solid #f3f4f6;
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dropdown-menu a:hover {
            background: #f8fafc;
            color: var(--primary-color);
            padding-left: 25px;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* Banner/Hero Section */
        .hero-section {
            position: relative;
            overflow: hidden;
            padding: 0;
            text-align: center;
            min-height: calc(100vh - 70px);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.22), rgba(255,255,255,0.06) 30%, rgba(255,255,255,0) 70%);
            pointer-events: none;
        }

        .hero-banner-image {
            width: 100%;
            display: block;
            object-fit: cover;
            object-position: center 20%;
            min-height: calc(100vh - 70px);
            filter: saturate(1.05) contrast(1.03);
        }

        body.home-page {
            padding-top: 0;
        }

        section,
        .hero-section {
            scroll-margin-top: 88px;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .btn-cta {
            background: white;
            color: var(--primary-color);
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .appointment-modal {
            width: min(960px, 100%);
            max-height: calc(100vh - 56px);
            overflow-y: auto;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 40px 80px rgba(15, 23, 42, 0.25);
            padding: 32px;
            position: relative;
            border: 1px solid rgba(59, 130, 246, 0.12);
        }

        .appointment-modal__close {
            position: absolute;
            right: 20px;
            top: 20px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1px solid rgba(148, 163, 184, 0.24);
            background: white;
            color: #0f172a;
            font-size: 1.6rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.12);
        }

        .appointment-modal__header {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .appointment-modal__header h2 {
            margin: 0;
            font-size: clamp(1.8rem, 2.4vw, 2.4rem);
            color: #0f172a;
        }

        .appointment-modal__header p {
            margin: 10px 0 0;
            color: #475569;
            line-height: 1.75;
            max-width: 640px;
        }

        .appointment-modal__banner {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 18px;
            align-items: center;
            background: #eff6ff;
            padding: 18px 22px;
            border-radius: 22px;
            border: 1px solid rgba(59, 130, 246, 0.18);
            margin-bottom: 28px;
        }

        .appointment-modal__banner p {
            margin: 8px 0 0;
            color: #334155;
            line-height: 1.7;
        }

        .appointment-modal__hotline {
            text-align: right;
        }

        .appointment-modal__hotline span {
            display: block;
            color: #64748b;
            font-size: 0.92rem;
        }

        .appointment-modal__hotline strong {
            display: block;
            margin-top: 6px;
            font-size: 1.2rem;
            color: #0f172a;
        }

        .appointment-modal .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .appointment-modal .form-group.full-width {
            grid-column: 1 / -1;
        }

        .appointment-modal .radio-group {
            display: flex;
            gap: 14px;
        }

        .appointment-modal .radio-option {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 16px;
            border: 1px solid #dbeafe;
            background: #ffffff;
            cursor: pointer;
        }

        .appointment-modal .radio-option:hover {
            border-color: #93c5fd;
        }

        .appointment-modal .appointment-form input,
        .appointment-modal .appointment-form select,
        .appointment-modal .appointment-form textarea {
            width: 100%;
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid #dbeafe;
            background: #f8fbff;
            font-size: 0.97rem;
            color: #0f172a;
            outline: none;
        }

        .appointment-modal .appointment-form input:focus,
        .appointment-modal .appointment-form select:focus,
        .appointment-modal .appointment-form textarea:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
            border-color: #2563eb;
        }

        .appointment-modal .btn-primary {
            width: 100%;
            padding: 16px;
            border-radius: 18px;
            background: linear-gradient(135deg, #2563eb, #0ea5ef);
            color: white;
            border: none;
            font-weight: 700;
            box-shadow: 0 20px 40px rgba(14, 165, 233, 0.24);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .appointment-modal .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 26px 55px rgba(14, 165, 233, 0.3);
        }

        .appointment-modal .success-message,
        .appointment-modal .error-message {
            margin-bottom: 22px;
        }

        @media (max-width: 900px) {
            .appointment-modal__banner {
                grid-template-columns: 1fr;
                text-align: left;
            }

            .appointment-modal__hotline {
                text-align: left;
            }
        }

        @media (max-width: 680px) {
            .appointment-modal {
                padding: 24px 20px;
            }

            .appointment-modal__header {
                flex-direction: column;
                align-items: stretch;
            }

            .appointment-modal .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .hero-content h1 {
                font-size: 24px;
            }

            .hero-content p {
                font-size: 14px;
            }

            .section {
                padding: 40px 15px;
            }

            .section-title {
                font-size: 24px;
            }

            .btn-cta {
                padding: 12px 30px;
                font-size: 14px;
            }
        }

        /* Section Styles */
        .section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 36px;
            text-align: center;
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-light);
            margin-bottom: 50px;
            font-size: 16px;
        }

        /* Doctor Cards */
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .doctor-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .doctor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .doctor-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .doctor-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .doctor-info {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .doctor-info h3 {
            font-size: 22px;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .doctor-specialty {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .doctor-bio {
            color: var(--text-light);
            margin-bottom: 15px;
            line-height: 1.6;
            flex: 1;
        }

        .doctor-contact {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: auto;
        }

        .doctor-contact a {
            padding: 8px 15px;
            background: var(--primary-color);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
            font-size: 14px;
        }

        .doctor-contact a:hover {
            background: var(--secondary-color);
        }

        /* News Cards */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .news-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .news-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: var(--primary-color);
            overflow: hidden;
        }

        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .news-content {
            padding: 20px;
        }

        .news-category {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .news-content h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .news-content p {
            color: var(--text-light);
            margin-bottom: 15px;
            font-size: 14px;
        }

        .news-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .news-link:hover {
            color: var(--secondary-color);
        }

        /* Footer */
        footer {
            background: var(--text-dark);
            color: white;
            padding: 50px 20px 20px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h4 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .footer-contact-item i {
            color: var(--primary-color);
            width: 25px;
            margin-top: 3px;
        }

        

        .map-container {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            height: 300px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            color: #9ca3af;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-container {
                height: auto;
                flex-wrap: wrap;
                padding: 15px 20px;
            }

            .nav-menu {
                display: none;
                flex-direction: column;
                gap: 15px;
                width: 100%;
                margin-left: 0;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid var(--border-color);
                align-items: flex-start;
            }

            .nav-menu.active {
                display: flex;
            }

            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                border: none;
                background: #f8fafc;
                margin-top: 10px;
                border-radius: 5px;
            }

            .dropdown-menu a {
                padding: 10px 15px;
                border-bottom: 1px solid #e5e7eb;
            }

            .dropdown-menu a:hover {
                background: var(--primary-color);
                color: white;
                padding-left: 20px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-buttons {
                width: 100%;
                gap: 10px;
                margin-top: 10px;
            }

            .btn-login,
            .btn-register {
                flex: 1;
                padding: 10px 15px;
                font-size: 14px;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .hero-section {
                padding: 60px 20px;
            }

            .section-title {
                font-size: 28px;
            }

            .doctors-grid,
            .news-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .map-container {
                height: 250px;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .navbar-container {
                padding: 10px 15px;
            }

            .logo {
                font-size: 18px;
            }

            .logo i {
                font-size: 22px;
            }

            .hero-content h1 {
                font-size: 24px;
            }

            .hero-content p {
                font-size: 14px;
            }

            .section {
                padding: 40px 15px;
            }

            .section-title {
                font-size: 24px;
            }

            .btn-cta {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="logo">
                <i class="fas fa-tooth"></i>
                SmileDental
            </a>
            <ul class="nav-menu">
                <li><a href="/" class="active">Trang chủ</a></li>
                <li><a href="/#doctors">Thông tin bác sĩ</a></li>
                <li><a href="/#news">Tin tức y tế</a></li>
                <li><a href="/about">Về chúng tôi</a></li>
                <li><a href="/contact">Liên hệ</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="/login" class="btn-login">Đăng nhập</a>
                <a href="/register" class="btn-register">Đăng ký</a>
            </div>
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <script>
        const navbar = document.querySelector('.navbar');
        const handleNavbarScroll = () => {
            if (!navbar) return;
            if (window.scrollY > 40) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        };
        window.addEventListener('scroll', handleNavbarScroll, { passive: true });
        window.addEventListener('load', handleNavbarScroll);

        document.addEventListener('DOMContentLoaded', () => {
            // Navbar scroll effect only
        });
    </script>
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <!-- About -->
                <div class="footer-section">
                    <h4><i class="fas fa-tooth"></i> SmileDental</h4>
                    <p>Chúng tôi cung cấp dịch vụ nha khoa chất lượng cao với đội ngũ nha sĩ giàu kinh nghiệm và trang thiết bị hiện đại nhất.</p>
                    <p style="margin-top: 15px; font-size: 14px;">© 2024 - 2026 SmileDental. Tất cả quyền được bảo lưu.</p>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h4>Thông tin liên hệ</h4>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Địa chỉ:</strong><br>
                            123 Đường Hùng Vương, Quận 5<br>
                            TP. Hồ Chí Minh, Việt Nam
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Điện thoại:</strong><br>
                            +84 28 3333 8888<br>
                            Hotline: 1900 8888
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email:</strong><br>
                            info@medicare.vn<br>
                            support@medicare.vn
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4>Liên kết nhanh</h4>
                    <ul>
                        <li><a href="/"><i class="fas fa-chevron-right"></i> Trang chủ</a></li>
                        <li><a href="/#doctors"><i class="fas fa-chevron-right"></i> Thông tin bác sĩ</a></li>
                        <li><a href="/#news"><i class="fas fa-chevron-right"></i> Tin tức y tế</a></li>
                        <li><a href="/about"><i class="fas fa-chevron-right"></i> Về chúng tôi</a></li>
                        <li><a href="/contact"><i class="fas fa-chevron-right"></i> Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Policies & Social -->
                <div class="footer-section">
                    <h4>Chính sách</h4>
                    <ul style="margin-bottom: 25px;">
                        <li><a href="/terms"><i class="fas fa-chevron-right"></i> Chính sách bảo mật</a></li>
                        <li><a href="/terms"><i class="fas fa-chevron-right"></i> Điều khoản dịch vụ</a></li>
                        <li><a href="/terms"><i class="fas fa-chevron-right"></i> Điều khoản sử dụng</a></li>
                    </ul>
                </div>
            </div>

            <!-- Map -->
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1156706949653!2d106.65287752346903!3d10.758869989357432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3e149e519f%3A0x87b295eec47a559f!2zQ8O0u!5e0!3m2!1svi!2svn!4v1234567890" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-links">
                    <a href="/terms">Chính sách bảo mật</a>
                    <a href="/terms">Điều khoản dịch vụ</a>
                    <a href="/contact">Liên hệ</a>
                    <a href="/about">Về chúng tôi</a>
                </div>
                <p>&copy; 2024 - 2026 SmileDental Việt Nam. Tất cả quyền được bảo lưu. Thiết kế bởi Dev Team.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.querySelector('.nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });

        // Active link indicator by current URL
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        const navLinks = document.querySelectorAll('.nav-menu > li > a:not(.dropdown-toggle)');

        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');

            if (href === '/') {
                if (currentPath === '/' && !currentHash) {
                    link.classList.add('active');
                }
                return;
            }

            if (href.startsWith('/#')) {
                if (currentPath === '/' && href === `/${currentHash}`) {
                    link.classList.add('active');
                }
                return;
            }

            if (href === currentPath) {
                link.classList.add('active');
            }
        });

        // Dropdown toggle for mobile
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const dropdownMenu = toggle.nextElementSibling;
                    dropdownMenu.classList.toggle('active');
                }
            });
        });
    </script>
</body>
</html>
