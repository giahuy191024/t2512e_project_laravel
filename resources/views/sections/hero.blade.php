<section class="hero">

    <div class="hero-content">

        <span class="hero-tag">
            ✨ Nha khoa tiêu chuẩn quốc tế
        </span>

        <h2>
            Nụ cười hoàn hảo <br>
            Tự tin tỏa sáng
        </h2>

        <p>
            Công nghệ nha khoa hiện đại hàng đầu,
            đội ngũ bác sĩ giàu kinh nghiệm,
            mang đến trải nghiệm chăm sóc tốt nhất.
        </p>

        <div class="hero-buttons">
            @auth
                <a href="/appointment" class="btn-primary">
                    Đặt lịch ngay
                </a>
            @endauth

            @guest
                <button class="btn-primary btn-login_popup">
                    Đặt lịch ngay
                </button>
            @endguest

            <button class="btn-secondary">
                Tìm hiểu thêm
            </button>
        </div>

    </div>

</section>
