@extends('layouts.layout_main')

@section('title', 'Contributors')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengembang</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></div>
            <div class="breadcrumb-item">Pengembang</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card modern-card">
                    <div class="card-header gradient-header">
                        <h4>Pengembang SI-JAKI</h4>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme slider" id="slider2">
                            <!-- Contributor 1 -->
                            <div class="contributor-slide">
                                <div class="contributor-image-wrapper with-light-effect">
                                    <img alt="Contributor 1" src="{{ asset('pengembang/team.jpg') }}" class="contributor-img">
                                </div>
                                <div class="slider-caption">
                                    <div class="slider-title">Team</div>
                                    <div class="slider-description">MSIB 7</div>
                                </div>
                            </div>
                            <!-- Contributor 2 -->
                            <div class="contributor-slide">
                                <div class="contributor-image-wrapper">
                                    <img alt="Contributor 2" src="{{ asset('pengembang/dzaky.png') }}" class="contributor-img">
                                </div>
                                <div class="slider-caption">
                                    <div class="slider-title">Dzaky Santino</div>
                                    <div class="slider-description">Fullstack Web Developer - Universitas Gunadarma
                                    </div>
                                </div>
                            </div>
                            <!-- Contributor 3 -->
                            <div class="contributor-slide">
                                <div class="contributor-image-wrapper">
                                    <img alt="Contributor 3" src="{{ asset('pengembang/tama.png') }}" class="contributor-img">
                                </div>
                                <div class="slider-caption">
                                    <div class="slider-title">Farhan Iqratama</div>
                                    <div class="slider-description">Fullstack Web Developer - Universitas Persada
                                        Indonesia Y.A.I</div>
                                </div>
                            </div>
                            <!-- Contributor 4 -->
                            <div class="contributor-slide">
                                <div class="contributor-image-wrapper">
                                    <img alt="Contributor 4" src="{{ asset('pengembang/faisal.png') }}" class="contributor-img">
                                </div>
                                <div class="slider-caption">
                                    <div class="slider-title">Faisal</div>
                                    <div class="slider-description">Fullstack Web Developer - Universitas Gunadarma
                                    </div>
                                </div>
                            </div>
                            <!-- Add more contributors as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('stisla/dist/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
<style>
    .contributor-img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        /* Ensures the image covers the container */
        border-radius: 10px;
    }

    .slider-caption {
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 15px;
        text-align: center;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .slider-title {
        font-size: 20px;
        font-weight: bold;
    }

    .slider-description {
        font-size: 14px;
        margin-top: 5px;
    }

    /* Optional: Improve the hover effect */
    .contributor-slide:hover .contributor-img {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    /* Modern Card Styling */
    .modern-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }

    /* Gradient Header */
    .gradient-header {
        background: linear-gradient(120deg, #007bff, #0056b3);
        color: #ffffff;
        text-align: center;
        padding: 15px;
        border-radius: 15px 15px 0 0;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* Contributor Images */
    .contributor-img {
        max-height: 500px;
        width: 180%;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contributor-img:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }


    /* Slider Caption */
    .slider-caption {
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 15px;
        text-align: center;
        position: absolute;
        bottom: 0;
        width: 100%;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .contributor-slide:hover .slider-caption {
        opacity: 1;
        transform: translateY(0);
    }

    .slider-title {
        font-size: 20px;
        font-weight: bold;
    }

    .slider-description {
        font-size: 14px;
        margin-top: 5px;
    }

    /* Owl Carousel Navigation */
    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel .owl-nav button.owl-next {
        position: absolute;
        top: 50%;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        font-size: 2rem;
        color: #fff;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        transform: translateY(-50%);
    }

    .owl-carousel .owl-nav button.owl-prev {
        left: -30px;
    }

    .owl-carousel .owl-nav button.owl-next {
        right: -30px;
    }

    .owl-carousel .owl-nav button:hover {
        background: rgba(0, 0, 0, 0.8);
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('stisla/dist/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#slider2").owlCarousel({
            items: 1,
            margin: 10,
            loop: true,
            nav: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
    });
</script>
@endpush