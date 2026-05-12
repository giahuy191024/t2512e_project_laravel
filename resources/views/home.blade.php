@extends('layouts.main')

@section('title', 'Trang Chủ - SmileDental - Nha Khoa Uy Tín')

@section('content')

<!-- Hero Banner -->
<section class="hero-section" id="home">
    <img src="/img/banner-dental.png" alt="SmileDental Banner" class="hero-banner-image" />
</section>

<!-- Doctors Section -->
<section class="section" id="doctors">
    <h2 class="section-title">Thông Tin Nha Sĩ</h2>
    <p class="section-subtitle">Đội ngũ nha sĩ chuyên môn cao, tận tâm với bệnh nhân</p>
    
    <div class="doctors-grid">
        <!-- Doctor 1 -->
        <div class="doctor-card">
            <div class="doctor-image">
                <img src="/img/image-1778161714802.jpeg" alt="Bác sĩ Lê Văn A" class="doctor-photo" />
            </div>
            <div class="doctor-info">
                <h3>ThS.BS.RS. Lê Văn A</h3>
                <div class="doctor-specialty">Chuyên khoa: Phục hình nha khoa & Cấy ghép implant</div>
                <p class="doctor-bio">
                    Nha sĩ chuyên khoa với 18+ năm kinh nghiệm. Chuyên về phục hình nha khoa, cấy ghép implant, làm cầu và mặt dán sứ.
                </p>
                <div class="doctor-contact">
                    <a class="btn-appointment" href="{{ route('appointment.book.form', ['doctor_id' => 1, 'doctor_name' => 'ThS.BS.RS. Lê Văn A', 'doctor_image' => '/img/image-1778161714802.jpeg', 'clinic_name' => 'Nha Khoa Trẻ', 'doctor_address' => 'Số 38 Nguy Như Kon Tum, Phường Nhân Chính, Quận Thanh Xuân, TP Hà Nội']) }}">
                        <i class="fas fa-calendar-alt"></i> Đặt khám
                    </a>
                </div>
            </div>
        </div>

        <!-- Doctor 2 -->
        <div class="doctor-card">
            <div class="doctor-image">
                <img src="/img/image-1778162087883.jpeg" alt="Bác sĩ Ngô Thị B" class="doctor-photo" />
            </div>
            <div class="doctor-info">
                <h3>BS.RS. Ngô Thị B</h3>
                <div class="doctor-specialty">Chuyên khoa: Nha chu & Chỉnh nha</div>
                <p class="doctor-bio">
                    Nha sĩ tư vấn nha chu và chỉnh nha có kinh nghiệm 12+ năm. Chuyên về điều trị nha chu, cắc cối, chỉnh nha thẩm mỹ.
                </p>
                <div class="doctor-contact">
                    <a class="btn-appointment" href="{{ route('appointment.book.form', ['doctor_id' => 2, 'doctor_name' => 'BS.RS. Ngô Thị B', 'doctor_image' => '/img/image-1778162087883.jpeg', 'clinic_name' => 'Nha Khoa Trẻ', 'doctor_address' => 'Số 38 Nguy Như Kon Tum, Phường Nhân Chính, Quận Thanh Xuân, TP Hà Nội']) }}">
                        <i class="fas fa-calendar-alt"></i> Đặt khám
                    </a>
                </div>
            </div>
        </div>

        <!-- Doctor 3 -->
        <div class="doctor-card">
            <div class="doctor-image">
                <img src="/img/image-1778162943609.jpeg" alt="Bác sĩ Lê Thị C" class="doctor-photo" />
            </div>
            <div class="doctor-info">
                <h3>BS. Lê Thị C</h3>
                <div class="doctor-specialty">Chuyên khoa: Niềng răng & Thẩm mỹ nha khoa</div>
                <p class="doctor-bio">
                    Bác sĩ chuyên sâu chỉnh nha và thẩm mỹ răng miệng, mang đến nụ cười tự tin cho bệnh nhân với phương pháp hiện đại.
                </p>
                <div class="doctor-contact">
                    <a class="btn-appointment" href="{{ route('appointment.book.form', ['doctor_id' => 3, 'doctor_name' => 'BS. Lê Thị C', 'doctor_image' => '/img/image-1778162943609.jpeg', 'clinic_name' => 'Nha Khoa Trẻ', 'doctor_address' => 'Số 38 Nguy Như Kon Tum, Phường Nhân Chính, Quận Thanh Xuân, TP Hà Nội']) }}">
                        <i class="fas fa-calendar-alt"></i> Đặt khám
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.btn-appointment {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    background: #ff9800;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-appointment:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

.doctor-contact {
    margin-top: auto;
    padding-top: 18px;
}
</style>

<!-- News Section -->
<section class="section" style="background: #f9fafb;" id="news">
    <h2 class="section-title">Tin Tức Nha Khoa</h2>
    <p class="section-subtitle">Cập nhật kiến thức nha khoa, mẹo chăm sóc và tin tức mới nhất</p>
    
    <div class="news-grid">
        <!-- News 1 -->
        <div class="news-card">
            <div class="news-image">
                <i class="fas fa-tooth"></i>
            </div>
            <div class="news-content">
                <span class="news-category">Chăm Sóc Răng</span>
                <h3>7 Cách Giữ Vệ Sinh Răng Miệng</h3>
                <p>Tìm hiểu về các cách đơn giản nhưng hiệu quả để bảo vệ và duy trì vệ sinh răng miệng trong cuộc sống hàng ngày.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>

        <!-- News 2 -->
        <div class="news-card">
            <div class="news-image">
                <img src="/images/con-sau-rang-1.jpg" alt="Phòng ngừa sâu răng" class="news-photo" />
            </div>
            <div class="news-content">
                <span class="news-category">Phòng Ngừa</span>
                <h3>Phòng Ngừa Sâu Răng Hiệu Quả</h3>
                <p>Các biện pháp phòng chống sâu răng giúp bạn có hàm răng khỏe mạnh và đẹp trắng suốt cuộc đời.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>

        <!-- News 3 -->
        <div class="news-card">
            <div class="news-image">
                <img src="/img/image-1778162943609.jpeg" alt="Tẩy trắng răng an toàn" class="news-photo" />
            </div>
            <div class="news-content">
                <span class="news-category">Thẩm Mỹ</span>
                <h3>Tẩy Trắng Răng An Toàn</h3>
                <p>Bài viết hướng dẫn chi tiết về các phương pháp tẩy trắng răng an toàn, hiệu quả và không gây tổn thương.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>

        <!-- News 4 -->
        <div class="news-card">
            <div class="news-image">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="news-content">
                <span class="news-category">Nha Chu</span>
                <h3>Bệnh Nha Chu - Dấu Hiệu & Điều Trị</h3>
                <p>Khám phá các dấu hiệu của bệnh nha chu, cách phòng ngừa và các phương pháp điều trị hiệu quả.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>

        <!-- News 5 -->
        <div class="news-card">
            <div class="news-image">
                <img src="/img/nieng-rang-loi-ich.jpeg" alt="Niềng răng đúng cách" class="news-photo" />
            </div>
            <div class="news-content">
                <span class="news-category">Chỉnh Nha</span>
                <h3>Niềng Răng - Quá Trình & Lợi Ích</h3>
                <p>Tìm hiểu về quá trình niềng răng, các lợi ích và cách chăm sóc sau khi niềng để có nụ cười đẹp.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>

        <!-- News 6 -->
        <div class="news-card">
            <div class="news-image">
                <img src="/images/ban-chai-dung-cach.jpg" alt="Chọn bàn chải đánh răng đúng cách" class="news-photo" />
            </div>
            <div class="news-content">
                <span class="news-category">Mẹo & Lời Khuyên</span>
                <h3>Chọn Bàn Chải Đánh Răng Đúng Cách</h3>
                <p>Các mẹo chọn bàn chải đánh răng, kem đánh răng phù hợp để có hiệu quả chăm sóc tối ưu.</p>
                <a href="#" class="news-link">Đọc thêm →</a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section" id="about">
    <h2 class="section-title">Về Chúng Tôi</h2>
    <p class="section-subtitle">SmileDental - Phòng Khám Nha Khoa Uy Tín Hàng Đầu</p>
    
    <div style="max-width: 900px; margin: 0 auto; text-align: center;">
        <p style="font-size: 16px; line-height: 1.8; color: #6b7280; margin-bottom: 20px;">
            <strong>SmileDental</strong> là một trong những phòng khám nha khoa hàng đầu tại Thành phố Hồ Chí Minh, 
            cung cấp các dịch vụ nha khoa toàn diện với đội ngũ nha sĩ chuyên môn cao, 
            trang thiết bị hiện đại và dịch vụ chất lượng.
        </p>
        <p style="font-size: 16px; line-height: 1.8; color: #6b7280; margin-bottom: 20px;">
            Chúng tôi cam kết mang lại nụ cười rạng rỡ và tự tin, đặt sức khỏe của bệnh nhân lên hàng đầu. 
            Với kinh nghiệm 10+ năm trong lĩnh vực nha khoa, chúng tôi tự hào phục vụ hàng nghìn bệnh nhân hài lòng.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 40px;">
            <div>
                <div style="font-size: 36px; color: #0ea5e9; margin-bottom: 10px;"><i class="fas fa-user-md"></i></div>
                <h4 style="margin-bottom: 5px;">20+ Nha Sĩ</h4>
                <p style="color: #6b7280;">Chuyên môn cao, giàu kinh nghiệm</p>
            </div>
            <div>
                <div style="font-size: 36px; color: #0ea5e9; margin-bottom: 10px;"><i class="fas fa-tooth"></i></div>
                <h4 style="margin-bottom: 5px;">15+ Dịch Vụ</h4>
                <p style="color: #6b7280;">Chăm sóc toàn diện</p>
            </div>
            <div>
                <div style="font-size: 36px; color: #0ea5e9; margin-bottom: 10px;"><i class="fas fa-users"></i></div>
                <h4 style="margin-bottom: 5px;">30,000+ Bệnh Nhân</h4>
                <p style="color: #6b7280;">Đã tin tưởng chúng tôi</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section" style="background: #f9fafb;" id="contact">
    <h2 class="section-title">Liên Hệ Với Chúng Tôi</h2>
    <p class="section-subtitle">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
    
    <div style="max-width: 800px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
        <div style="text-align: center;">
            <div style="font-size: 32px; color: #0ea5e9; margin-bottom: 15px;"><i class="fas fa-phone"></i></div>
            <h4>Gọi Chúng Tôi</h4>
            <p style="color: #6b7280;">+84 28 3333 8888</p>
            <p style="color: #6b7280;">Hotline: 1900 8888</p>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 32px; color: #0ea5e9; margin-bottom: 15px;"><i class="fas fa-envelope"></i></div>
            <h4>Email Chúng Tôi</h4>
            <p style="color: #6b7280;">info@medicare.vn</p>
            <p style="color: #6b7280;">support@medicare.vn</p>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 32px; color: #0ea5e9; margin-bottom: 15px;"><i class="fas fa-map-marker-alt"></i></div>
            <h4>Địa Chỉ Chúng Tôi</h4>
            <p style="color: #6b7280;">123 Đường Hùng Vương</p>
            <p style="color: #6b7280;">Quận 5, TP. Hồ Chí Minh</p>
        </div>
    </div>
</section>

<!-- Terms Section -->
<section class="section" id="terms">
    <h2 class="section-title">Điều Khoản Sử Dụng</h2>
    <p class="section-subtitle">Vui lòng đọc kỹ trước khi sử dụng dịch vụ nha khoa</p>
    
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px; color: #0ea5e9;">1. Điều Khoản Chung</h3>
            <p style="margin-bottom: 20px; color: #6b7280;">
                Bằng cách sử dụng website SmileDental, bạn đồng ý tuân thủ tất cả các điều khoản và điều kiện 
                được nêu dưới đây. Chúng tôi bảo lưu quyền cập nhật hoặc thay đổi bất kỳ điều khoản nào mà không cần thông báo trước.
            </p>

            <h3 style="margin-bottom: 15px; color: #0ea5e9;">2. Sử Dụng Dịch Vụ</h3>
            <p style="margin-bottom: 20px; color: #6b7280;">
                Bạn đồng ý chỉ sử dụng website này cho các mục đích hợp pháp. 
                Nghiêm cấm sử dụng website cho bất kỳ hoạt động bất hợp pháp hoặc xâm hại đến các quyền của người khác.
            </p>

            <h3 style="margin-bottom: 15px; color: #0ea5e9;">3. Bản Quyền Và Sở Hữu Trí Tuệ</h3>
            <p style="margin-bottom: 20px; color: #6b7280;">
                Tất cả nội dung trên website (bao gồm văn bản, hình ảnh, video, logo) là tài sản của SmileDental 
                và được bảo vệ bởi các luật bản quyền quốc tế.
            </p>

            <h3 style="margin-bottom: 15px; color: #0ea5e9;">4. Từ Chối Trách Nhiệm</h3>
            <p style="margin-bottom: 20px; color: #6b7280;">
                Website được cung cấp "như có". SmileDental không đưa ra bất kỳ bảo đảm nào về tính chính xác, 
                đầy đủ hoặc phù hợp của nội dung và dịch vụ.
            </p>

            <h3 style="margin-bottom: 15px; color: #0ea5e9;">5. Liên Hệ Hỗ Trợ</h3>
            <p style="color: #6b7280;">
                Nếu bạn có bất kỳ câu hỏi hoặc khiếu nại về các điều khoản này, vui lòng liên hệ với chúng tôi 
                tại <strong>info@smiledental.vn</strong> hoặc gọi <strong>+84 28 3333 8888</strong>.
            </p>
        </div>
    </div>
</section>

@endsection
