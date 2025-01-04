@extends('layouts.layout_auth')

@section('title', 'Login')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="login-box">
    <div class="left-right-container">
        <div class="image-container">
            <img src="{{ url('logo/logo-jaki.png') }}" alt="AdminLTE Logo" class="brand-image">
        </div>
        <div class="form-container">
            @if (session('success'))
            <div class="alert alert-success resizable">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger resizable" role="alert">
                {!! implode('', $errors->all('<li>:message</li>')) !!}
            </div>
            @endif
            @if($errors->has('session_expired'))
            <div class="alert alert-warning">
                {{ $errors->first('session_expired') }}
            </div>
            @endif
            <form method="POST" action="{{ route('login.authenticate') }}">
                @csrf
                <!-- Login Header -->
                <div class="login-header">
                    <h2 class="login-title">LOGIN</h2>
                </div>
                    <div class="input-group mb-3">
                    <input type="text" name="name" id="name" class="form-control form-control-modern"
                        placeholder="Username" value="{{ old('name') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control form-control-modern"
                        placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="show-password">
                        <i id="toggle-password" class="fas fa-eye"></i>
                        <label for="toggle-password">Tampilkan Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
                <hr>

                <!-- Footer -->
                <div class="footer mt-4"
                    style="text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <p class="blue-gradient-text" style="margin: 0; font-size: 1rem;">&copy; {{ date('Y') }} created by:</p>
                    <img src="{{ asset('logo/lldikti3.png') }}" alt="Support Logo" class="footer-logo" style="width: 40px; height: auto;">
                    <img src="{{ asset('logo/logo-msib.png') }}" alt="University Logo" class="footer-logo" style="width: 40px; height: auto;">
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .login-header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .login-title {
        font-weight: bold;
        font-size: 2rem;
        text-align: center;
        margin: 0 15px;
        background: linear-gradient(90deg, rgba(30, 144, 255, 1), rgba(70, 130, 180, 0.6), rgba(30, 144, 255, 1));
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradientTextAnimation 3s ease-in-out infinite;
    }

    @keyframes gradientTextAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .side-image {
        width: 40px;
        height: auto;
        transition: transform 0.3s ease;
        animation: bounce 1.5s infinite alternate;
    }

    @keyframes bounce {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .side-image:hover {
        transform: scale(1.1);
    }

    @keyframes greyGradientBorder {
        0% {
            border-color: rgba(169, 169, 169, 0.6);
            box-shadow: 0px 0px 10px rgba(169, 169, 169, 0.2);
        }

        50% {
            border-color: rgba(105, 105, 105, 0.8);
            box-shadow: 0px 0px 15px rgba(105, 105, 105, 0.4);
        }

        100% {
            border-color: rgba(169, 169, 169, 0.6);
            box-shadow: 0px 0px 10px rgba(169, 169, 169, 0.2);
        }
    }

    @keyframes whiteGradientBackground {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .login-box {
        position: relative;
        inline-size: 100%;
        max-inline-size: 850px;
        margin: 0 auto;
        padding: 40px;
        border-radius: 15px;
        border: 2px solid rgba(52, 148, 245, 0.6);
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.8), rgba(245, 245, 245, 0.9), rgba(255, 255, 255, 0.8));
        background-size: 200% 200%;
        animation: fadeIn 1s ease-in-out, blueGradientBorder 3s infinite ease-in-out, whiteGradientBackground 5s infinite;
        box-shadow: 0px 0px 10px rgba(52, 148, 245, 0.2);
        overflow: hidden;
        z-index: 1;
    }

    .login-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -50%;
        width: 70%;
        height: 100%;
        border-radius: 15px;
        background: radial-gradient(circle at 50%, rgba(52, 148, 245, 0.15), transparent 80%);
        animation: moveBlueGlow 6s infinite ease-in-out;
        z-index: -1;
    }

    @keyframes moveBlueGlow {
        0% {
            transform: translateX(-50%);
        }

        50% {
            transform: translateX(50%);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes blueGradientBorder {

        0%,
        100% {
            border-color: rgba(52, 148, 245, 0.6);
            box-shadow: 0px 0px 10px rgba(52, 148, 245, 0.3);
        }

        50% {
            border-color: rgba(0, 86, 179, 0.6);
            box-shadow: 0px 0px 15px rgba(0, 86, 179, 0.3);
        }
    }

    .card {
        border: 1px solid #e0e0e0;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
    }

    .btn-primary {
        background-color: #0056b3;
        border-color: #0056b3;
        border-radius: 10px;
        font-size: 16px;
        padding: 12px 24px;
    }

    body {
        background-image: url('{{ asset("bguniv.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: backgroundMove 15s ease-in-out infinite;
    }

    @keyframes backgroundMove {
        0% {
            background-position: center;
        }

        50% {
            background-position: center top;
        }

        100% {
            background-position: center;
        }
    }

    .left-right-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .left-right-container img {
        max-inline-size: 90%;
    }

    .left-right-container .form-container {
        flex: 1;
        padding-left: 40px;
    }

    .left-right-container .image-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .show-password {
        display: flex;
        align-items: center;
        font-size: 14px;
        margin-top: 5px;
    }

    .show-password input[type="checkbox"] {
        margin-right: 5px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .show-password {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .show-password label {
        margin-left: 5px;
    }

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        width: 100%;
    }

    .animated-image {
        transition: opacity 0.5s ease-in-out;
    }

    .fade-out {
        opacity: 0;
    }

    .fade-in {
        opacity: 1;
    }

    @keyframes fadeInLeftToRight {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .footer-logo {
        width: 50px;
        height: auto;
    }

    .show-password {
        display: flex;
        align-items: center;
        cursor: pointer;
        gap: 5px;
    }

    .show-password i {
        font-size: 14px;
        color: #333;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .show-password label {
        font-size: 12px;
        color: #333;
    }

    .show-password i.active {
        color: #007bff;
        transform: scale(1.1);
    }

    .blue-gradient-text {
        font-size: 1rem;
        font-weight: bold;
        background: linear-gradient(90deg, rgba(30, 144, 255, 1), rgba(70, 130, 180, 0.8), rgba(30, 144, 255, 1));
        background-size: 200% 200%;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: blueGradientAnimation 3s infinite ease-in-out;
    }

    @keyframes blueGradientAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .blue-gradient-image {
        width: 40px;
        height: auto;
        filter: grayscale(100%);
        transition: transform 0.3s ease, filter 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .blue-gradient-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(30, 144, 255, 0.5), rgba(135, 206, 250, 0.5), rgba(30, 144, 255, 0.5));
        z-index: 2;
        mix-blend-mode: multiply;
    }

    .blue-gradient-image:hover {
        filter: grayscale(80%);
        transform: scale(1.1);
    }
    
    @media screen and (max-width: 768px) {
    /* Untuk Tablet */
    .login-box {
        max-inline-size: 90%;
        padding: 20px;
    }

    .left-right-container {
        flex-direction: column;
        align-items: center;
    }

    .left-right-container .form-container {
        padding-left: 0;
        margin-top: 20px;
        text-align: center;
    }

    .left-right-container img {
        max-width: 80%;
    }

    .btn-primary {
        font-size: 14px;
        padding: 10px 20px;
    }

    .login-title {
        font-size: 1.5rem;
    }

    .footer {
        flex-direction: column;
        gap: 5px;
    }

    .footer-logo {
        width: 30px;
    }
}

@media screen and (max-width: 480px) {
    /* Untuk Mobile */
    .login-box {
        max-inline-size: 90%;
        padding: 10px;
    }

    .left-right-container {
        flex-direction: column;
        align-items: center;
    }

    .login-title {
        font-size: 1.25rem;
    }

    .btn-primary {
        font-size: 12px;
        padding: 8px 16px;
    }

    .footer {
        flex-direction: column;
        gap: 5px;
        font-size: 0.8rem;
    }

    .footer-logo {
        width: 25px;
    }
}
</style>
@endpush

<script>
    document.getElementById('show-password').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        passwordField.type = this.checked ? 'text' : 'password';
    });
</script>
<script>
document.getElementById("toggle-password").addEventListener("click", function() {
    const passwordInput = document.getElementById("password");
    const icon = this;

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.add("active"); // Add active class for animation
        icon.classList.replace("fa-eye", "fa-eye-slash"); // Switch to eye-slash icon
    } else {
        passwordInput.type = "password";
        icon.classList.remove("active"); // Remove active class
        icon.classList.replace("fa-eye-slash", "fa-eye"); // Switch back to eye icon
    }
});
</script>
@endsection