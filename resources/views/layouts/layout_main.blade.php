<!DOCTYPE html>
<html lang="en">
<style>
    /* Animasi Fade-In untuk Halaman */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .fade-in {
        animation: fadeIn 1s ease-in-out;
    }

    /* Navbar Background with Blue Gradient */
    .gradient-blue-navbar {
        background: linear-gradient(90deg, #007bff, #0056b3, #007bff);
        /* Gradien biru dari terang ke gelap */
        background-size: 300% 300%;
        animation: blueGradientAnimation 5s ease infinite;
        /* Optional animated gradient */
        height: 60px;
        /* Adjust based on your navbar height */
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        /* Ensure it sits behind navbar content */
    }

    /* Keyframes for Gradient Animation */
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

    /* Navbar Content Styling */
    .navbar {
        position: relative;
        /* Ensures navbar content sits above the background */
        z-index: 1;
        color: white;
        /* White text for better contrast */
    }

    /* Navbar Links */
    .navbar a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .navbar a:hover {
        color: #dcdcdc;
        /* Light grey on hover */
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Dashboard') &mdash; SI-JAKI</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/prism/prism.css')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/components.css') }}">

    <link rel="icon" href="{{ asset('logo/logo-sijaki-title.png') }}">
    @stack('styles')
</head>

<body>    
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg gradient-blue-navbar"></div>

            @include('partials.navbar') {{-- Navbar Partial --}}
            @include('partials.sidebar') {{-- Sidebar Partial --}}

            <!-- Main Content -->
            <div class="main-content gradient-blue-content">
                <section class="section">
                    {{-- <div class="section-header">
                        <h1>@yield('header-title', 'Dashboard')</h1>
                    </div> --}}

                    @yield('content')
                    @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            swal({
                                title: 'Berhasil!',
                                text: "{{ session('success') }}",
                                icon: 'success',
                                timer: 3000,
                                buttons: false,
                            });
                        });
                    </script>
                    @endif

                    @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            swal({
                                title: 'Error!',
                                text: "{{ session('error') }}",
                                icon: 'error',
                                timer: 3000,
                                buttons: false,
                            });
                        });
                    </script>
                    @endif
                </section>
            </div>

            @include('partials.footer') {{-- Footer Partial --}}
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('stisla/dist/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('stisla/dist/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('stisla/dist/assets/modules/prism/prism.js')}}"></script>    

    <!-- Page Specific JS File -->
    <script src="{{ asset('stisla/dist/assets/js/page/bootstrap-modal.js')}}"></script>
    
    <!-- Template JS File -->
    <script src="{{ asset('stisla/dist/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/custom.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('stisla/dist/assets/modules/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('fade-in');
        });
    </script>
    @stack('scripts')
</body>

</html>