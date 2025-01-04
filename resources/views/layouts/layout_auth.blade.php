<!DOCTYPE html>
<html lang="en">

<style>
    /* Loading Screen Styles */
    .loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Background Layer with Blur Effect */
    .loading-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #007bff, #0056b3, #007bff);
        background-size: 300% 300%;
        animation: gradientAnimation 3s ease infinite;
        filter: blur(10px); /* Apply blur to the background */
        z-index: 1; /* Keep background behind spinner and text */
    }

    /* Content Layer (Spinner and Text) */
    .loading-content {
        position: relative;
        z-index: 2; /* Ensure content is above the blurred background */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    /* Spinner Style */
    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #fff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    /* Keyframes for Spinner Rotation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Keyframes for Background Gradient Animation */
    @keyframes gradientAnimation {
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

    /* Styling for the Text (SI-JAKI) */
    .loading-text {
        font-size: 30px;
        font-weight: bold;
        color: white;
        margin-top: 20px; /* Spacing between spinner and text */
        text-transform: uppercase;
        letter-spacing: 3px;
        animation: textAnimation 2s ease infinite;
    }

    /* Text Animation (Optional) */
    @keyframes textAnimation {
        0% {
            opacity: 0.8;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(1.1);
        }
        100% {
            opacity: 0.8;
            transform: scale(1);
        }
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Login') &mdash; SI-JAKI</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/components.css') }}">

    <link rel="icon" href="{{ asset('logo/logo-sijaki-title.png') }}">
    @stack('styles')
</head>

<body>
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-background"></div> <!-- Background with blur -->
        <div class="loading-content">
            {{-- <div class="spinner"></div> --}}
            <div class="loading-text">SI-JAKI</div>
        </div>
    </div>
    <div id="app" class="d-flex flex-column justify-content-center align-items-center min-vh-100">
        @yield('content')
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('stisla/dist/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('stisla/dist/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/custom.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('stisla/dist/assets/modules/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        // Show loading screen on page load
        document.addEventListener("DOMContentLoaded", function() {
            var loadingScreen = document.getElementById("loading-screen");
    
            // Simulate loading time (adjust this according to your needs)
            setTimeout(function() {
                loadingScreen.style.display = "none"; // Hide loading screen after animation is complete
            }, 2000); // Hide after 2 seconds (adjust as needed)
        });
    
        // Show loading screen before navigating to a new page or clicking a menu item
        window.addEventListener("beforeunload", function() {
            document.getElementById("loading-screen").style.display = "flex";
        });
    </script>
    @stack('scripts')
</body>

</html>