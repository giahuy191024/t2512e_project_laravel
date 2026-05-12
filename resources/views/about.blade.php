@extends('layouts.main')

@section('title', 'Về Chúng Tôi - MediConnect')

@section('content')
<section class="hero-section">
    <div class="hero-content">
        <h1>Về MediConnect</h1>
        <p>Nền tảng kết nối chăm sóc sức khỏe hiện đại, giúp bệnh nhân tiếp cận dịch vụ y tế nhanh chóng và minh bạch.</p>
    </div>
</section>

<section class="section">
    <h2 class="section-title">Giới Thiệu Dự Án</h2>
    <p class="section-subtitle">MediConnect ra đời để giải quyết nhu cầu y tế thực tế của người dùng.</p>

    <div class="about-grid">
        <article class="about-card">
            <h3><i class="fas fa-calendar-check"></i> Lý Do Ra Đời</h3>
            <p>
                MediConnect được xây dựng để giải quyết tình trạng đặt lịch khám thủ công, thiếu đồng bộ và mất nhiều thời gian.
                Nền tảng cho phép bệnh nhân tìm bác sĩ, chọn khung giờ phù hợp và xác nhận lịch khám chỉ trong vài bước.
            </p>
        </article>
        <article class="about-card">
            <h3><i class="fas fa-shield-virus"></i> Cung Cấp Thông Tin Phòng Bệnh</h3>
            <p>
                Ngoài đặt lịch, MediConnect còn cung cấp nội dung y tế phổ thông về phòng bệnh,
                giúp người dùng chủ động chăm sóc sức khỏe và giảm nguy cơ mắc các bệnh phổ biến.
            </p>
        </article>
    </div>
</section>

<section class="section" style="background: #f8fafc;">
    <h2 class="section-title">Tầm Nhìn & Sứ Mệnh</h2>
    <p class="section-subtitle">Kết nối Bệnh nhân - Bác sĩ nhanh chóng, minh bạch, dễ tiếp cận.</p>

    <div class="about-grid">
        <article class="about-card">
            <h3><i class="fas fa-eye"></i> Tầm Nhìn</h3>
            <p>
                Trở thành nền tảng kết nối y tế số đáng tin cậy, giúp mọi người dân tiếp cận dịch vụ khám chữa bệnh
                chất lượng với quy trình rõ ràng và thuận tiện.
            </p>
        </article>
        <article class="about-card">
            <h3><i class="fas fa-bullseye"></i> Sứ Mệnh</h3>
            <p>
                Cung cấp dịch vụ kết nối Bệnh nhân - Bác sĩ nhanh chóng, minh bạch;
                giảm thời gian chờ đợi, tối ưu trải nghiệm đặt lịch và nâng cao hiệu quả chăm sóc sức khỏe cộng đồng.
            </p>
        </article>
    </div>
</section>

<section class="section">
    <h2 class="section-title">Giá Trị Cốt Lõi</h2>
    <p class="section-subtitle">Nền tảng phát triển dựa trên ba giá trị trung tâm.</p>

    <div class="core-grid">
        <article class="core-card">
            <div class="core-icon"><i class="fas fa-user-tie"></i></div>
            <h3>Chuyên nghiệp</h3>
            <p>Chuẩn hóa quy trình đặt lịch, quản lý lịch hẹn và hiển thị thông tin bác sĩ một cách rõ ràng.</p>
        </article>
        <article class="core-card">
            <div class="core-icon"><i class="fas fa-heart"></i></div>
            <h3>Tận tâm</h3>
            <p>Lấy trải nghiệm bệnh nhân làm trọng tâm, hỗ trợ nhanh và cung cấp thông tin y tế dễ hiểu.</p>
        </article>
        <article class="core-card">
            <div class="core-icon"><i class="fas fa-microchip"></i></div>
            <h3>Công nghệ</h3>
            <p>Ứng dụng công nghệ số để tự động hóa tác vụ, đồng bộ dữ liệu và tối ưu hiệu quả kết nối.</p>
        </article>
    </div>
</section>

<section class="section" style="background: #f8fafc;">
    <h2 class="section-title">Our Team</h2>
    <p class="section-subtitle">Đội ngũ phát triển đa chuyên môn với định hướng y tế số bền vững.</p>

    <div class="team-cover">
        <i class="fas fa-users"></i>
        <div>
            <h3>Hình ảnh minh họa đội ngũ</h3>
            <p>Đang sử dụng icon y tế chuyên nghiệp. Bạn có thể thay bằng ảnh nhóm thực tế khi sẵn sàng.</p>
        </div>
    </div>

    <div class="team-grid">
        <article class="team-card">
            <div class="team-avatar"><i class="fas fa-user-md"></i></div>
            <h4>BS. Nguyễn Minh An</h4>
            <p>Medical Advisor</p>
        </article>
        <article class="team-card">
            <div class="team-avatar"><i class="fas fa-laptop-code"></i></div>
            <h4>Trần Quỳnh Chi</h4>
            <p>Product Engineer</p>
        </article>
        <article class="team-card">
            <div class="team-avatar"><i class="fas fa-chart-line"></i></div>
            <h4>Lê Gia Huy</h4>
            <p>Operations & Data</p>
        </article>
        <article class="team-card">
            <div class="team-avatar"><i class="fas fa-comments"></i></div>
            <h4>Phạm Khánh Linh</h4>
            <p>Patient Success</p>
        </article>
    </div>
</section>

<style>
    .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .about-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .about-card h3 {
        margin-bottom: 12px;
        color: #0ea5e9;
        font-size: 20px;
    }

    .core-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .core-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .core-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        background: linear-gradient(135deg, #0ea5e9, #06b6d4);
        font-size: 24px;
    }

    .team-cover {
        background: white;
        border: 1px dashed #94a3b8;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .team-cover i {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 24px;
        flex-shrink: 0;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .team-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .team-avatar {
        width: 72px;
        height: 72px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .team-card h4 {
        margin-bottom: 6px;
        color: #1f2937;
    }

    .team-card p {
        color: #6b7280;
        font-size: 14px;
    }
</style>
@endsection
