{{-- resources/views/main/home.blade.php --}}
@extends('layouts.layout_main')

@section('title', 'Beranda')

@section('content')

<div class="section-header">
    <h1>Menu Utama</h1>
</div>

<div class="marquee-container gradient-border">
    <div class="marquee">
        <span class="welcome-text">
            Selamat Datang di SI-JAKI - Sistem Informasi Jejak Pembinaan Perguruan Tinggi
        </span>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card custom-card text-center border">
            <div class="card-body">
                <div class="image-container mx-auto mb-3">
                    <img src="pts.png" alt="Perguruan Tinggi Swasta Alt" class="img-fluid image image-2">
                </div>
                <h5 class="card-title">Perguruan Tinggi Swasta</h5>
                <p class="card-text">{{ number_format($swastaCount) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card custom-card text-center border">
            <div class="card-body">
                <div class="image-container mx-auto mb-3">
                    <img src="ptn.png" alt="Perguruan Tinggi Negeri Alt" class="img-fluid image image-2">
                </div>
                <h5 class="card-title">Perguruan Tinggi Negeri</h5>
                <p class="card-text">{{ number_format($negeriCount) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card custom-card text-center border">
            <div class="card-body">
                <div class="image-container mx-auto mb-3">
                    <img src="group.png" alt="Data User Alt" class="img-fluid image image-2">
                </div>
                <h5 class="card-title">Data User</h5>
                <p class="card-text">{{ number_format($userCount) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card custom-card text-center border">
            <div class="card-body">
                <div class="image-container mx-auto mb-3">
                    <img src="thesis.png" alt="Total Laporan Alt" class="img-fluid image image-2">
                </div>
                <h5 class="card-title">Total Laporan</h5>
                <p class="card-text">{{ number_format($laporanCount) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6"> <!-- Kolom kiri -->
        <div class="card modern-card">
            <div class="card-header gradient-header">
                <h4>Statistik Laporan</h4>
            </div>
            <div class="card-body">
                <canvas id="myChart" height="182"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6"> <!-- Kolom kanan -->
        <div class="card modern-card">
            <div class="card-header gradient-header">
                <h4>Statistik Laporan Per Tim Kerja</h4>
            </div>
            <div class="card-body">
                <canvas id="userChart" height="182"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .custom-card {
        border: 2px solid #007bff;
        /* Blue border color */
        border-radius: 15px;
        /* Rounded corners */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Optional: Adds shadow for a modern look */
        overflow: hidden;
        /* Ensures content stays inside rounded corners */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Adds a hover effect */
    }

    .custom-card:hover {
        transform: translateY(-5px);
        /* Lifts the card on hover */
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        /* Adds a stronger shadow on hover */
    }

    /* Icon Container Styling */
    .icon-container {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.5rem;
    }

    /* Card Title Styling */
    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Card Text Styling */
    .card-text {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    /* Custom Colors for Icon Backgrounds */
    .bg-primary {
        background-color: #007bff;
    }

    .bg-danger {
        background-color: #dc3545;
    }

    .bg-warning {
        background-color: #ffc107;
    }

    .bg-success {
        background-color: #28a745;
    }

    /* Marquee Container with Animated Blue Sky Background */
    .marquee-container {
        background: linear-gradient(90deg, #ffffff, #f3f5f6, #f5f9fa);
        /* Blue sky gradient */
        background-size: 300% 300%;
        /* Larger size for animation effect */
        animation: blueSkyAnimation 8s ease infinite;
        /* Animation applied to the background */
        padding: 15px;
        /* Space around the text */
        border-radius: 10px;
        /* Optional: Rounded corners */
        text-align: center;
        /* Center-align the text */
        color: white;
        /* White text for contrast */
        font-family: Arial, sans-serif;
        /* Text font */
        font-size: 18px;
        /* Text size */
        font-weight: bold;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Optional: Subtle shadow */
        margin-bottom: 20px;
        /* Adjust the spacing as needed */
    }

    /* Keyframes for Animated Background */
    @keyframes blueSkyAnimation {
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

    /* Optional Styling for Marquee Text */
    .marquee {
        overflow: hidden;
        /* Prevent overflow */
        white-space: nowrap;
        /* Prevent text wrapping */
    }

    .welcome-text {
        display: inline-block;
        /* Ensure smooth scrolling */
        animation: marqueeText 10s linear infinite;
        /* Marquee text animation */
    }

    /* Keyframes for Scrolling Marquee Text */
    @keyframes marqueeText {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Keyframes for Live Gradient Animation */
    @keyframes gradientBorderAnimation {
        0% {
            background: linear-gradient(white, white) padding-box,
                linear-gradient(90deg, #007bff, #0056b3, #007bff) border-box;
        }

        50% {
            background: linear-gradient(white, white) padding-box,
                linear-gradient(90deg, #007bff, #0056b3, #007bff) border-box;
        }

        100% {
            background: linear-gradient(white, white) padding-box,
                linear-gradient(90deg, #007bff, #0056b3, #007bff) border-box;
        }
    }

    /* Styling for Welcome Text */
    .welcome-text {
        font-size: 20px;
        /* Adjust font size as needed */
        font-weight: bold;
        /* Optional: make the text bold */
        color: #333;
        /* Dark grey for better visibility */
        white-space: nowrap;
        /* Ensures the text stays in one line */
    }

    .marquee span {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 15s linear infinite;
        font-weight: bold;
        color: #333;
    }

    /* Keyframes for the marquee animation */
    @keyframes marquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Image Container Styling */
    .image-container {
        display: flex;
        justify-content: center;
        /* Center horizontally */
        align-items: center;
        /* Center vertically */
        height: 100px;
        /* Set a fixed height for consistency */
    }

    /* Images inside the container */
    .image-container img {
        max-width: 80px;
        /* Adjust the size of the image */
        max-height: 80px;
        /* Ensure images fit within the container */
        display: block;
        animation: pulse 5s infinite ease-in-out;
        /* Apply pulse animation */
    }

    /* Keyframes for Pulse Animation */
    @keyframes pulse {
        0% {
            transform: scale(1);
            /* Initial size */
            opacity: 1;
            /* Full opacity */
        }

        50% {
            transform: scale(1.1);
            /* Slightly larger size */
            opacity: 0.8;
            /* Reduced opacity */
        }

        100% {
            transform: scale(1);
            /* Back to original size */
            opacity: 1;
            /* Full opacity */
        }
    }

    /* Modern Card Styling */
    .modern-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    /* Gradient Text Styling */
    .gradient-text {
        font-size: 24px;
        font-weight: bold;
        background: linear-gradient(90deg, #007bff, #0056b3, #007bff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-flex;
        align-items: center;
    }

    /* Dot Light Animation */
    .dot-light {
        width: 10px;
        height: 10px;
        margin-left: 10px;
        background: radial-gradient(circle, #007bff, #0056b3, transparent);
        border-radius: 50%;
        animation: dotPulse 1.5s infinite;
    }

    /* Animation for Dot Light */
    @keyframes dotPulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.5);
            opacity: 0.5;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Detail Name Styling */
    .detail-name {
        font-size: 14px;
        color: #6c757d;
    }

    /* Center and style the section-header */
    .section-header {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 8vh;
        background: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    /* Adjust font size and style for the header */
    .section-header h1 {
        font-size: 1rem;
        font-weight: bold;
        color: #343a40;
        margin: 0;
        text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-header h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .section-header h1 {
            font-size: 2rem;
        }
    }

    .gradient-header {
        background: linear-gradient(120deg, #007bff, #0056b3);
        /* Blue gradient */
        color: #ffffff;
        /* White text for contrast */
        text-align: center;
        padding: 15px;
        border-radius: 15px 15px 0 0;
        /* Rounded corners for the top of the card */
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        /* Slight spacing for a modern look */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        // Fungsi untuk membatasi panjang teks
        function truncateText(text, maxLength) {
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        }

        // === Grafik Statistik Total Laporan ===
        var ctx = document.getElementById('myChart').getContext('2d');
        var lineGradient = ctx.createLinearGradient(0, 0, 0, 400);
        lineGradient.addColorStop(0, "#3fc9fb");
        lineGradient.addColorStop(1, "#007bff");

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini', 'Tahun Ini'],
                datasets: [
                    {
                        label: 'Data Laporan',
                        data: [{{ $todayCount }}, {{ $weeklyCount }}, {{ $monthlyCount }}, {{ $yearlyCount }}],
                        borderColor: lineGradient,
                        backgroundColor: 'rgba(63, 201, 251, 0.4)',
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: lineGradient,
                        pointBorderColor: '#ffffff',
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: lineGradient,
                        pointRadius: 8,
                        pointHoverRadius: 12,
                    },
                ],
            },
            options: {
                responsive: true,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart',
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6c757d',
                        },
                        grid: {
                            color: 'rgba(108,117,125,0.1)',
                        },
                    },
                    x: {
                        ticks: {
                            color: '#6c757d',
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#6c757d',
                        },
                    },
                },
            },
        });

        // === Grafik Statistik Laporan Per Pengguna ===
        var userCtx = document.getElementById('userChart').getContext('2d');
        var userNames = @json(array_column($userLaporanData->toArray(), 'user_name')).map(name => truncateText(name, 15));
        var laporanCounts = @json(array_column($userLaporanData->toArray(), 'laporan_count'));

        var userChart = new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: userNames, // Nama pengguna yang dipersingkat
                datasets: [{
                    label: 'Data Laporan Per Tim Kerja',
                    data: laporanCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6c757d',
                        },
                        grid: {
                            color: 'rgba(108,117,125,0.1)',
                        },
                    },
                    x: {
                        ticks: {
                            color: '#6c757d',
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#6c757d',
                        },
                    },
                },
            },
        });

        // === Counter Animation for Detail Statistics ===
        const detailValues = document.querySelectorAll(".detail-value");
        detailValues.forEach((value) => {
            const target = parseInt(value.getAttribute("data-count"), 10);
            const increment = Math.ceil(target / 100);
            let current = 0;

            const updateCount = () => {
                if (current < target) {
                    current += increment;
                    value.firstChild.textContent = current.toLocaleString();
                    requestAnimationFrame(updateCount);
                } else {
                    value.firstChild.textContent = target.toLocaleString();
                }
            };

            setTimeout(updateCount, 500);
        });

        // === Image Swapping for Icons ===
        const swappers = document.querySelectorAll(".image-swapper");

        swappers.forEach((swapper) => {
            const images = swapper.querySelectorAll("img");
            let currentIndex = 0;

            function swapImages() {
                images.forEach((img, index) => {
                    img.classList.remove("active");
                    if (index === currentIndex) {
                        img.classList.add("active");
                    }
                });

                currentIndex = (currentIndex + 1) % images.length;
            }

            setInterval(swapImages, 3000);

            swapImages();
        });
    });
</script>
@endpush
