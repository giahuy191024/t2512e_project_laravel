@extends('layouts.main')

@section('title', 'Liên Hệ - SmileDental')

@section('content')

<!-- Hero Banner -->
<section class="hero-section" id="home">
    <div class="hero-content">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Hãy liên hệ để được tư vấn và hỗ trợ tốt nhất</p>
    </div>
</section>

<!-- Contact Content -->
<section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 40px; align-items: start;">

            <!-- Contact Information -->
            <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h2 style="color: #0ea5e9; margin-bottom: 30px; text-align: center; border-bottom: 2px solid #0ea5e9; padding-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Thông Tin Liên Hệ
                </h2>

                <!-- Address -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                        <div style="background: #0ea5e9; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 style="color: #374151; margin-bottom: 8px; font-size: 18px;">Địa Chỉ Văn Phòng</h3>
                            <p style="color: #6b7280; line-height: 1.6; margin: 0;">
                                123 Đường Hùng Vương<br>
                                Quận 5, TP. Hồ Chí Minh<br>
                                Việt Nam
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                        <div style="background: #06b6d4; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3 style="color: #374151; margin-bottom: 8px; font-size: 18px;">Số Điện Thoại Hotline</h3>
                            <p style="color: #6b7280; line-height: 1.6; margin: 0;">
                                <strong>Điện thoại:</strong> +84 28 3333 8888<br>
                                <strong>Hotline:</strong> 1900 8888<br>
                                <small style="color: #9ca3af;">(Hỗ trợ 24/7)</small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                        <div style="background: #10b981; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3 style="color: #374151; margin-bottom: 8px; font-size: 18px;">Email</h3>
                            <p style="color: #6b7280; line-height: 1.6; margin: 0;">
                                <strong>Thông tin:</strong> info@smiledental.vn<br>
                                <strong>Hỗ trợ:</strong> support@smiledental.vn<br>
                                <small style="color: #9ca3af;">(Phản hồi trong 24 giờ)</small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; border-left: 4px solid #0ea5e9;">
                    <h4 style="color: #0c4a6e; margin-bottom: 10px;"><i class="fas fa-clock"></i> Giờ Làm Việc</h4>
                    <div style="color: #374151;">
                        <p style="margin: 5px 0;"><strong>Thứ 2 - Thứ 6:</strong> 8:00 - 18:00</p>
                        <p style="margin: 5px 0;"><strong>Thứ 7:</strong> 8:00 - 16:00</p>
                        <p style="margin: 5px 0;"><strong>Chủ nhật:</strong> Nghỉ</p>
                        <p style="margin: 5px 0;"><strong>Nghỉ lễ:</strong> Theo quy định</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h2 style="color: #0ea5e9; margin-bottom: 30px; text-align: center; border-bottom: 2px solid #0ea5e9; padding-bottom: 15px;">
                    <i class="fas fa-paper-plane"></i> Gửi Tin Nhắn
                </h2>

                @if(session('success'))
                    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> <strong>{{ session('success') }}</strong>
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 20px;">
                        <i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra lại thông tin đã nhập.
                    </div>
                @endif

                <form id="contactForm" method="POST" action="/contact" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf
                    <!-- Name -->
                    <div>
                        <label for="name" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-user"></i> Họ Tên <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                               style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="Nhập họ tên của bạn">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-envelope"></i> Email <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                               style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="example@email.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-phone"></i> Số Điện Thoại <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}"
                               style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="090xxxxxxx">
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-comment"></i> Nội Dung Tin Nhắn <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea id="message" name="message" required rows="5"
                                  style="width: 100%; padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box; resize: vertical; min-height: 120px;"
                                  placeholder="Vui lòng mô tả chi tiết vấn đề bạn cần hỗ trợ...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            style="background: linear-gradient(135deg, #0ea5e9, #06b6d4); color: white; padding: 15px 30px; border: none; border-radius: 50px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px;">
                        <i class="fas fa-paper-plane"></i> Gửi Tin Nhắn
                    </button>
                </form>

                <!-- Privacy Note -->
                <div style="margin-top: 20px; padding: 15px; background: #fef3c7; border-radius: 8px; border-left: 4px solid #f59e0b;">
                    <p style="color: #92400e; margin: 0; font-size: 14px;">
                        <i class="fas fa-shield-alt"></i> <strong>Bảo mật thông tin:</strong> Chúng tôi cam kết bảo mật tuyệt đối thông tin cá nhân của bạn theo chính sách bảo mật.
                    </p>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div style="margin-top: 60px; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h2 style="color: #0ea5e9; margin-bottom: 20px; text-align: center;">
                <i class="fas fa-map-marked-alt"></i> Tìm Đường Đến Phòng Khám
            </h2>
            <div style="border-radius: 10px; overflow: hidden; height: 400px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1156706949653!2d106.65287752346903!3d10.758869989357432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3e149e519f%3A0x87b295eec47a559f!2zQ8O0u!5e0!3m2!1svi!2svn!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection

<style>
/* Form Focus Styles */
#contactForm input:focus,
#contactForm textarea:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

/* Button Hover */
#contactForm button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(6, 182, 212, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .section {
        padding: 40px 15px;
    }

    .hero-content h1 {
        font-size: 36px;
    }

    #contactForm button {
        padding: 12px 25px;
        font-size: 15px;
    }
}
</style>
