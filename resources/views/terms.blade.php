@extends('layouts.main')

@section('title', 'Điều Khoản Sử Dụng - SmileDental')

@section('content')

<!-- Hero Banner -->
<section class="hero-section" id="home">
    <div class="hero-content">
        <h1>Điều Khoản Sử Dụng</h1>
        <p>Quy định và điều kiện sử dụng dịch vụ của SmileDental</p>
    </div>
</section>

<!-- Terms Content -->
<section class="section">
    <div style="max-width: 1000px; margin: 0 auto;">
        <!-- Table of Contents -->
        <div style="background: #f8fafc; padding: 30px; border-radius: 10px; margin-bottom: 40px; border-left: 4px solid #0ea5e9;">
            <h2 style="margin-bottom: 20px; color: #0ea5e9;">📋 Mục Lục</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                <a href="#account" class="toc-link" style="display: block; padding: 10px 15px; background: white; border-radius: 5px; text-decoration: none; color: #374151; transition: all 0.3s ease; border: 1px solid #e5e7eb;">
                    <i class="fas fa-user-shield"></i> Quy định về tài khoản
                </a>
                <a href="#intellectual" class="toc-link" style="display: block; padding: 10px 15px; background: white; border-radius: 5px; text-decoration: none; color: #374151; transition: all 0.3s ease; border: 1px solid #e5e7eb;">
                    <i class="fas fa-copyright"></i> Quyền sở hữu trí tuệ
                </a>
                <a href="#liability" class="toc-link" style="display: block; padding: 10px 15px; background: white; border-radius: 5px; text-decoration: none; color: #374151; transition: all 0.3s ease; border: 1px solid #e5e7eb;">
                    <i class="fas fa-shield-alt"></i> Giới hạn trách nhiệm
                </a>
                <a href="#cancellation" class="toc-link" style="display: block; padding: 10px 15px; background: white; border-radius: 5px; text-decoration: none; color: #374151; transition: all 0.3s ease; border: 1px solid #e5e7eb;">
                    <i class="fas fa-calendar-times"></i> Chính sách hủy/đổi lịch
                </a>
            </div>
        </div>

        <!-- Account Regulations -->
        <div id="account" class="terms-section" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="color: #0ea5e9; margin-bottom: 20px; border-bottom: 2px solid #0ea5e9; padding-bottom: 10px;">
                <i class="fas fa-user-shield"></i> 1. Quy Định Về Tài Khoản
            </h2>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">1.1 Trách nhiệm bảo mật thông tin đăng nhập</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Người dùng có trách nhiệm tuyệt đối trong việc bảo mật thông tin đăng nhập của mình bao gồm:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Không chia sẻ tên đăng nhập và mật khẩu với bất kỳ ai</li>
                <li style="margin-bottom: 8px;">• Không lưu trữ thông tin đăng nhập ở nơi dễ bị truy cập</li>
                <li style="margin-bottom: 8px;">• Thông báo ngay lập tức cho SmileDental khi phát hiện tài khoản bị xâm phạm</li>
                <li style="margin-bottom: 8px;">• Đăng xuất tài khoản sau mỗi phiên sử dụng trên thiết bị công cộng</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">1.2 Quyền và nghĩa vụ của người dùng</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Khi đăng ký tài khoản tại SmileDental, bạn đồng ý:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Cung cấp thông tin chính xác và cập nhật</li>
                <li style="margin-bottom: 8px;">• Sử dụng dịch vụ đúng mục đích</li>
                <li style="margin-bottom: 8px;">• Tuân thủ các quy định của pháp luật</li>
                <li style="margin-bottom: 8px;">• Thông báo kịp thời về thay đổi thông tin cá nhân</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">1.3 Xử lý vi phạm</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                SmileDental có quyền tạm ngừng hoặc chấm dứt tài khoản trong các trường hợp:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Vi phạm điều khoản sử dụng</li>
                <li style="margin-bottom: 8px;">• Cung cấp thông tin sai lệch</li>
                <li style="margin-bottom: 8px;">• Sử dụng tài khoản cho mục đích bất hợp pháp</li>
                <li style="margin-bottom: 8px;">• Không hoạt động trong thời gian dài (6 tháng)</li>
            </ul>
        </div>

        <!-- Intellectual Property -->
        <div id="intellectual" class="terms-section" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="color: #0ea5e9; margin-bottom: 20px; border-bottom: 2px solid #0ea5e9; padding-bottom: 10px;">
                <i class="fas fa-copyright"></i> 2. Quyền Sở Hữu Trí Tuệ
            </h2>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">2.1 Nội dung được bảo vệ</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Tất cả nội dung trên website SmileDental đều được bảo vệ bởi quyền sở hữu trí tuệ, bao gồm:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Tin tức y tế và kiến thức nha khoa</li>
                <li style="margin-bottom: 8px;">• Hướng dẫn cách phòng ngừa và chữa trị bệnh</li>
                <li style="margin-bottom: 8px;">• Hình ảnh, video và đồ họa</li>
                <li style="margin-bottom: 8px;">• Logo, thương hiệu và thiết kế giao diện</li>
                <li style="margin-bottom: 8px;">• Phần mềm và mã nguồn hệ thống</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">2.2 Quyền sử dụng</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Người dùng được phép:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Sử dụng nội dung cho mục đích cá nhân, phi thương mại</li>
                <li style="margin-bottom: 8px;">• Chia sẻ thông tin với điều kiện giữ nguyên nguồn gốc</li>
                <li style="margin-bottom: 8px;">• Trích dẫn hợp lý với mục đích tham khảo</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">2.3 Cấm sử dụng</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Nghiêm cấm các hành vi sau đây:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Sao chép, phân phối nội dung mà không được phép</li>
                <li style="margin-bottom: 8px;">• Sử dụng nội dung cho mục đích thương mại</li>
                <li style="margin-bottom: 8px;">• Thay đổi, chỉnh sửa nội dung gốc</li>
                <li style="margin-bottom: 8px;">• Xóa bỏ thông tin bản quyền</li>
            </ul>
        </div>

        <!-- Liability Limitations -->
        <div id="liability" class="terms-section" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="color: #0ea5e9; margin-bottom: 20px; border-bottom: 2px solid #0ea5e9; padding-bottom: 10px;">
                <i class="fas fa-shield-alt"></i> 3. Giới Hạn Trách Nhiệm
            </h2>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">3.1 Tư vấn y tế mang tính tham khảo</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                <strong>Quan trọng:</strong> Tất cả thông tin y tế trên website SmileDental chỉ mang tính chất tham khảo và giáo dục.
                Chúng tôi không thể thay thế cho tư vấn y tế chuyên môn từ bác sĩ.
            </p>

            <div style="background: #fef3c7; padding: 20px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 20px;">
                <h4 style="color: #92400e; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i> Lưu ý quan trọng</h4>
                <p style="color: #92400e; margin: 0;">
                    Thông tin về bệnh tật, cách phòng ngừa và chữa trị được cung cấp dựa trên kiến thức y học chung.
                    Không sử dụng thông tin này để tự chẩn đoán hoặc điều trị mà không có sự giám sát của bác sĩ chuyên khoa.
                </p>
            </div>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">3.2 Miễn trừ trách nhiệm</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                SmileDental không chịu trách nhiệm về:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Hậu quả từ việc áp dụng thông tin y tế mà không có sự tư vấn chuyên môn</li>
                <li style="margin-bottom: 8px;">• Thiệt hại gián tiếp hoặc đặc biệt phát sinh từ việc sử dụng website</li>
                <li style="margin-bottom: 8px;">• Sự cố kỹ thuật, virus hoặc lỗi hệ thống ngoài tầm kiểm soát</li>
                <li style="margin-bottom: 8px;">• Nội dung từ bên thứ ba được liên kết trên website</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">3.3 Khuyến nghị sử dụng</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Để đảm bảo sức khỏe và an toàn, chúng tôi khuyến nghị:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Tham khảo ý kiến bác sĩ trước khi áp dụng bất kỳ thông tin nào</li>
                <li style="margin-bottom: 8px;">• Sử dụng thông tin như nguồn tham khảo bổ sung, không phải thay thế</li>
                <li style="margin-bottom: 8px;">• Liên hệ trực tiếp với phòng khám để được tư vấn cụ thể</li>
            </ul>
        </div>

        <!-- Cancellation Policy -->
        <div id="cancellation" class="terms-section" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="color: #0ea5e9; margin-bottom: 20px; border-bottom: 2px solid #0ea5e9; padding-bottom: 10px;">
                <i class="fas fa-calendar-times"></i> 4. Chính Sách Hủy/Đổi Lịch
            </h2>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">4.1 Quy định hủy lịch</h3>
            <div style="overflow-x: auto; margin-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse; background: #f9fafb; border-radius: 8px;">
                    <thead>
                        <tr style="background: #0ea5e9; color: white;">
                            <th style="padding: 12px; text-align: left; border-radius: 8px 0 0 0;">Thời gian hủy</th>
                            <th style="padding: 12px; text-align: left;">Phí hủy</th>
                            <th style="padding: 12px; text-align: left; border-radius: 0 8px 0 0;">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; color: #059669; font-weight: 600;">Trước 24 giờ</td>
                            <td style="padding: 12px; color: #059669;">Miễn phí</td>
                            <td style="padding: 12px; color: #6b7280;">Có thể hủy hoặc đổi lịch thoải mái</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; color: #d97706; font-weight: 600;">12-24 giờ</td>
                            <td style="padding: 12px; color: #d97706;">20% phí dịch vụ</td>
                            <td style="padding: 12px; color: #6b7280;">Phí hủy 20% giá trị dịch vụ</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; color: #dc2626; font-weight: 600;">Dưới 12 giờ</td>
                            <td style="padding: 12px; color: #dc2626;">50% phí dịch vụ</td>
                            <td style="padding: 12px; color: #6b7280;">Phí hủy 50% giá trị dịch vụ</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; color: #dc2626; font-weight: 600;">Không đến</td>
                            <td style="padding: 12px; color: #dc2626;">100% phí dịch vụ</td>
                            <td style="padding: 12px; color: #6b7280;">Phí hủy toàn bộ giá trị dịch vụ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">4.2 Quy định đổi lịch</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Việc đổi lịch khám được thực hiện theo các quy định sau:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• Có thể đổi lịch miễn phí nếu thông báo trước 24 giờ</li>
                <li style="margin-bottom: 8px;">• Đổi lịch trong vòng 12-24 giờ: phí 10% giá trị dịch vụ</li>
                <li style="margin-bottom: 8px;">• Đổi lịch trong vòng dưới 12 giờ: phí 30% giá trị dịch vụ</li>
                <li style="margin-bottom: 8px;">• Chỉ được đổi lịch tối đa 2 lần cho mỗi lịch hẹn</li>
            </ul>

            <h3 style="color: #374151; margin: 25px 0 15px 0;">4.3 Cách thức thực hiện</h3>
            <p style="line-height: 1.7; color: #6b7280; margin-bottom: 15px;">
                Để hủy hoặc đổi lịch, vui lòng liên hệ với chúng tôi qua:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px; color: #6b7280;">
                <li style="margin-bottom: 8px;">• <strong>Điện thoại:</strong> Gọi hotline 1900 8888</li>
                <li style="margin-bottom: 8px;">• <strong>Email:</strong> support@smiledental.vn</li>
                <li style="margin-bottom: 8px;">• <strong>Website:</strong> Đăng nhập tài khoản và thao tác trực tuyến</li>
                <li style="margin-bottom: 8px;">• <strong>Trực tiếp:</strong> Đến phòng khám để thông báo</li>
            </ul>

            <div style="background: #dbeafe; padding: 20px; border-radius: 8px; border-left: 4px solid #3b82f6;">
                <h4 style="color: #1e40af; margin-bottom: 10px;"><i class="fas fa-info-circle"></i> Lưu ý</h4>
                <p style="color: #1e40af; margin: 0;">
                    Việc hủy/đổi lịch cần được xác nhận từ phía SmileDental. Chúng tôi sẽ gửi thông báo xác nhận qua SMS hoặc email.
                </p>
            </div>
        </div>

        <!-- Contact Info -->
        <div style="background: #f0f9ff; padding: 30px; border-radius: 10px; text-align: center; border: 1px solid #bae6fd;">
            <h3 style="color: #0c4a6e; margin-bottom: 15px;">Cần hỗ trợ thêm?</h3>
            <p style="color: #374151; margin-bottom: 20px;">
                Nếu bạn có bất kỳ câu hỏi nào về các điều khoản sử dụng, vui lòng liên hệ với chúng tôi.
            </p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="tel:0283338888" style="background: #0ea5e9; color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-phone"></i> Gọi ngay
                </a>
                <a href="mailto:info@smiledental.vn" style="background: #06b6d4; color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-envelope"></i> Email
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

<style>
.toc-link:hover {
    background: #0ea5e9 !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(14, 165, 233, 0.3);
}

@media (max-width: 768px) {
    .toc-link {
        margin-bottom: 10px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px 6px;
    }
}
</style>

<script>
// Smooth scroll to sections
document.querySelectorAll('.toc-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetSection = document.querySelector(targetId);

        if (targetSection) {
            const offsetTop = targetSection.offsetTop - 100;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// Highlight active section in TOC
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.terms-section');
    const tocLinks = document.querySelectorAll('.toc-link');

    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (pageYOffset >= sectionTop - 150) {
            current = section.getAttribute('id');
        }
    });

    tocLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});
</script>
