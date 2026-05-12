<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Login & Registration</title>
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>
<header>
    <h2 class="logo">SmileDental</h2>
    <nav class="navigation">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/#doctors">Services</a>
        <a href="/contact">Contact</a>
        <button class="btn-login_popup">Login</button>
    </nav>
</header>
<div class="login-page">
    <div class="login-image">
        <img src="/img/auth-login-image.png" alt="Dental login image">
    </div>
    <div class="wrapper">
    <span class="icon-close"><ion-icon name="close"></ion-icon></span>
    <div class="form-box login">
        <h2>Login</h2>
        <form action="/auth" method="POST">
            @csrf
            <input type="hidden" name="type" value="login">
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="remember-forgot">
                <label class="checkbox"><input type="checkbox">Remember me</label>
                <a href="#">Forgot password</a>
            </div>
            <button class="btn" type="submit">Login</button>
            <div class="Login-register">
                <p>Khong co tai khoan ?
                    <a href="#" class="register-link">Register</a>
                </p>
            </div>
        </form>
    </div>

    <div class="form-box registration">
        <h2>Registration</h2>
        <form action="/auth" method="POST">
            @csrf
            <input type="hidden" name="type" value="register">
            <div class="input-box">
                <span class="icon"><ion-icon name="person"></ion-icon></span>
                <input type="text" name="name" required>
                <label>Username</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="remember-forgot">
                <label class="checkbox"><input type="checkbox">Agree to the terms & conditions</label>
            </div>
            <button class="btn" type="submit">Register</button>
            <div class="Login-register">
                <p>Already have an account ?
                    <a href="#" class="login-link">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
</div>
<script src="{{asset('js/auth.js')}}" defer></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
