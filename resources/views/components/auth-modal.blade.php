<div class="wrapper">
    <span class="icon-close"><ion-icon name="close"></ion-icon></span>

    {{-- ===== LOGIN ===== --}}
    <div class="form-box login">
        <h2>Đăng nhập</h2>
        <p class="subtitle">Chào mừng quay lại, vui lòng nhập thông tin tài khoản.</p>

        <form action="/auth" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="type" value="login">

            <div class="input-box">
                <label>Email</label>
                <div class="input-wrap">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="input-box">
                <label>Mật khẩu</label>
                <div class="input-wrap">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" placeholder="••••••••" autocomplete="new-password" required>
                </div>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Ghi nhớ đăng nhập</label>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <button class="btn" type="submit">Đăng nhập</button>

            <div class="Login-register">
                <p>Chưa có tài khoản?
                    <a href="#" class="register-link">Đăng ký ngay</a>
                </p>
            </div>
        </form>
    </div>

    {{-- ===== REGISTER ===== --}}
    <div class="form-box registration">
        <h2>Tạo tài khoản</h2>
        <p class="subtitle">Đăng ký để trải nghiệm đầy đủ dịch vụ của chúng tôi.</p>

        <form action="/auth" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="type" value="register">

            <div class="input-box">
                <label>Họ và tên</label>
                <div class="input-wrap">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="full_name" placeholder="Nguyễn Văn A"
                           autocomplete="off" required>
                </div>
            </div>

            <div class="input-box">
                <label>Email</label>
                <div class="input-wrap">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" placeholder="you@example.com"
                           autocomplete="off" required>
                </div>
            </div>

{{--            <div class="input-box">--}}
{{--                <label>Số điện thoại</label>--}}
{{--                <div class="input-wrap">--}}
{{--                    <span class="icon"><ion-icon name="call-outline"></ion-icon></span>--}}
{{--                    <input type="tel" name="phone" placeholder="0901234567"--}}
{{--                           pattern="[0-9]{9,11}" maxlength="11"--}}
{{--                           autocomplete="off" required>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="input-box">
                <label>Mật khẩu</label>
                <div class="input-wrap">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" placeholder="Ít nhất 8 ký tự"
                           autocomplete="new-password" required>
                </div>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" required> Tôi đồng ý với điều khoản dịch vụ</label>
            </div>

            <button class="btn" type="submit">Tạo tài khoản</button>

            <div class="Login-register">
                <p>Đã có tài khoản?
                    <a href="#" class="login-link">Đăng nhập</a>
                </p>
            </div>
        </form>
    </div>
</div>
