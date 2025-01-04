@extends('layouts.layout_main')

@section('title', 'Jejak Pembinaan')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Jejak Pembinaan - {{ $pts->nama_pt }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
            <div class="breadcrumb-item"><a href="{{ route('laporan-pts.index') }}">Laporan</a></div>
            <div class="breadcrumb-item">Jejak Pembinaan</div>
        </div>
    </div>

    <div class="section-body">
        <form method="GET" action="{{ route('laporan-pts.show', $pts->uuid) }}" class="mb-4">
            <div class="row">
                <div class="col-md-2 mb-2">
                    <label for="jenis_kegiatan">Filter by Jenis Kegiatan:</label>
                    <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-control">
                        <option value="">Semua</option>
                        <option value="Rapat/Audiensi" {{ request('jenis_kegiatan')=='Rapat/Audiensi' ? 'selected' : ''
                            }}>Rapat/Audiensi</option>
                        <option value="Visitasi" {{ request('jenis_kegiatan')=='Visitasi' ? 'selected' : '' }}>Visitasi
                        </option>
                        <option value="Monitoring & Evaluasi" {{ request('jenis_kegiatan')=='Monitoring & Evaluasi'
                            ? 'selected' : '' }}>Monitoring & Evaluasi</option>
                        <option value="Aduan/Laporan" {{ request('jenis_kegiatan')=='Aduan/Laporan' ? 'selected' : ''
                            }}>Aduan/Laporan</option>
                        <option value="Teguran/Sanksi" {{ request('jenis_kegiatan')=='Teguran/Sanksi' ? 'selected' : ''
                            }}>Teguran/Sanksi</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label for="filter_year">Filter by Tahun:</label>
                    <input type="number" name="filter_year" id="filter_year" class="form-control"
                        value="{{ request('filter_year') }}" placeholder="2024">
                </div>

                <div class="col-md-2 mb-2">
                    <label for="filter_month">Filter by Bulan:</label>
                    <select name="filter_month" id="filter_month" class="form-control">
                        <option value="">Semua</option>
                        @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" {{ request('filter_month')==$m
                            ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label for="filter_pokja">Lingkup Tim Kerja</label>
                    <select name="filter_pokja" id="filter_pokja" class="form-control">
                        <option value="">Semua</option>
                        @foreach ($pokjaList as $pokja)
                            <option value="{{ $pokja }}" {{ request('filter_pokja') == $pokja ? 'selected' : '' }}>{{ $pokja }}</option>
                        @endforeach
                    </select>
                </div>                

                <div class="col-md-2 align-self-end mb-2">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('laporan-pts.printToPdf', ['uuid' => $pts->uuid, 'jenis_kegiatan' => request('jenis_kegiatan'), 'filter_year' => request('filter_year'), 'filter_month' => request('filter_month'), 'filter_pokja' => request('filter_pokja')]) }}"
                            class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> Print to PDF
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @php
                            $currentDate = null;
                            @endphp

                            @foreach($laporan->sortByDesc('tanggal_kegiatan') as $item)
                            @php
                                $itemDate = \Carbon\Carbon::parse($item->tanggal_kegiatan)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY');
                                $createdAtTimestamp = \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->timestamp * 1000;
                            @endphp

                            @if($currentDate !== $itemDate)
                                <div class="time-label">
                                    <span class="bg-primary">{{ $itemDate }}</span>
                                </div>
                                @php
                                $currentDate = $itemDate;
                                @endphp
                            @endif

                            <div>
                                @switch($item->jenis_kegiatan)
                                @case('Rapat/Audiensi')
                                <div class="icon-container bg-info">
                                    <i class="fas fa-comments animated-icon"></i>
                                </div>
                                @break
                                @case('Visitasi')
                                <div class="icon-container bg-success">
                                    <i class="fas fa-map-marker-alt animated-icon"></i>
                                </div>
                                @break
                                @case('Monitoring & Evaluasi')
                                <div class="icon-container bg-warning">
                                    <i class="fas fa-tasks animated-icon"></i>
                                </div>
                                @break
                                @case('Aduan/Laporan')
                                <div class="icon-container bg-dark">
                                    <i class="fas fa-envelope animated-icon"></i>
                                </div>
                                @break
                                @case('Teguran/Sanksi')
                                <div class="icon-container bg-danger">
                                    <i class="fas fa-ban animated-icon"></i>
                                </div>
                                @break
                                @default
                                <div class="icon-container bg-secondary">
                                    <i class="fas fa-file animated-icon"></i>
                                </div>
                                @endswitch

                                <div class="timeline-item animated-card">
                                    <span class="time"><i class="fas fa-clock"></i> {{
                                        \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->isoFormat('HH:mm [WIB]') }}</span>

                                    <h3 class="timeline-header gradient-text">{{ $item->jenis_kegiatan }}</h3>

                                    <div class="timeline-body">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <p><strong>Tempat Kegiatan:</strong> {{ $item->tempat_kegiatan }}</p>
                                                <p><strong>Lingkup Tim Kerja:</strong></p>
                                                <ul class="pokja-list">
                                                    @foreach(explode(';', $item->pokja) as $anggota)
                                                        <li>• {{ trim($anggota) }}</li>
                                                    @endforeach
                                                </ul>                                                  
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Tanggal Dibuat:</strong>
                                                    {{
                                                    \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}
                                                </p>
                                                <p><strong>Dibuat oleh:</strong> {{ $item->createdbyuser }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <p><strong>Ringkasan:</strong></p>
                                            <div class="resume-content" style="margin-top: -15px;">
                                                <div class="resume-preview">
                                                    {{ Str::limit($item->resume, 100) }}
                                                    @if(strlen($item->resume) > 100)
                                                    <a href="#" class="show-more" data-id="{{ $item->id }}">
                                                        Lihat Selengkapnya
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="resume-full-{{ $item->id }}" style="display: none;">
                                                    {{ $item->resume }}
                                                    <a href="#" class="show-less" data-id="{{ $item->id }}">
                                                        Sembunyikan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Responsive Timeline Footer Buttons -->
                                    <div class="timeline-footer row mx-0">
                                        <div class="col-6 col-md-3 mb-2 px-1">
                                            @if(!empty($item->dokumen_notula))
                                                <a href="{{ asset('storage/' . $item->dokumen_notula) }}" class="btn btn-primary btn-block btn-sm" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Notula
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-block btn-sm" disabled>
                                                    <i class="fas fa-file-pdf"></i> Tidak Ada Dokumen Notula
                                                </button>
                                            @endif
                                        </div>                                                                                                                    
                                        <div class="col-6 col-md-3 mb-2 px-1">
                                            <a href="{{ asset('storage/' . $item->dokumen_undangan) }}"
                                                class="btn btn-info btn-block btn-sm" target="_blank">
                                                <i class="fas fa-file-pdf"></i> Undangan
                                            </a>
                                        </div>
                                        @if ($item->canEdit)
                                        <div class="col-6 col-md-3 mb-2 px-1">
                                            <a href="{{ route('laporan-pts.edit', $item->uuid) }}"
                                                class="btn btn-warning btn-block btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2 px-1">
                                            <form action="{{ route('laporan-pts.destroy', $item->uuid) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-block btn-sm"
                                                    onclick="return confirm('Anda yakin ingin menghapus kegiatan ini?');">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    .timeline-header {
        font-size: 18px;
        /* Default font size */
        font-weight: bold;
        /* Make the text stand out */
        text-transform: uppercase;
        /* Convert text to uppercase for a modern look */
        color: #ffffff;
        /* White text for contrast */
        padding: 10px 15px;
        /* Add padding around the text */
        background: linear-gradient(120deg, #007bff, #0056b3);
        /* Rounded corners */
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
        text-align: center;
        /* Center align the text */
        margin-bottom: 15px;
        /* Add spacing below the header */
        transition: all 0.3s ease;
        /* Smooth transition for hover effect */
    }

    /* Optional Gradient Text Effect */
    .timeline-header.gradient-text {
        background: linear-gradient(90deg, #0056b3, #003d73);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        /* Makes text background-based */
    }

    /* Responsive Font Sizes */
    @media (max-width: 1024px) {
        .timeline-header {
            font-size: 16px;
            /* Slightly smaller font for tablets */
        }
    }

    @media (max-width: 768px) {
        .timeline-header {
            font-size: 14px;
            /* Smaller font for mobile devices */
        }
    }

    @media (max-width: 480px) {
        .timeline-header {
            font-size: 12px;
            /* Even smaller font for very small screens */
        }
    }

    .modern-timeline-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover Effect */
    .modern-timeline-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* Icon Container */
    .icon-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 40%;
        margin: 5px;
        color: white;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover Animation */
    .icon-container:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    /* Animated Icon */
    .animated-icon {
        animation: pulse 1.5s infinite ease-in-out;
    }

    /* Pulse Keyframes */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Background Colors */
    .bg-info {
        background: linear-gradient(135deg, #3fc9fb, #007bff);
    }

    .bg-success {
        background: linear-gradient(135deg, #4caf50, #1e7e34);
    }

    .bg-warning {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }

    .bg-dark {
        background: linear-gradient(135deg, #343a40, #212529);
    }

    .bg-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .bg-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
    }

    /* General Fade-In Animation */
    .fade-in {
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Fade-In and Slide-Up Animation */
    .fade-in-up {
        animation: fadeInUp 1s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hover Effects for Buttons */
    .btn {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }

    .timeline {
        margin: 0 0 45px;
        padding: 0;
        position: relative;
    }

    .timeline::before {
        border-radius: 0.25rem;
        background-color: #dee2e6;
        bottom: 0;
        content: "";
        left: 31px;
        margin: 0;
        position: absolute;
        top: 0;
        width: 4px;
    }

    .timeline>div {
        margin-bottom: 15px;
        margin-right: 10px;
        position: relative;
    }

    .timeline>div>.timeline-item {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        border-radius: 0.25rem;
        background-color: #fff;
        color: #495057;
        margin-left: 60px;
        margin-right: 15px;
        margin-top: 0;
        padding: 0;
        position: relative;
    }

    .timeline>div>.timeline-item>.time {
        color: #999;
        float: right;
        font-size: 12px;
        padding: 10px;
    }

    .timeline>div>.timeline-item>.timeline-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        color: #495057;
        font-size: 16px;
        line-height: 1.1;
        margin: 0;
        padding: 10px;
    }

    .timeline>div>.timeline-item>.timeline-body,
    .timeline>div>.timeline-item>.timeline-footer {
        padding: 10px;
    }

    .timeline>div>.fa,
    .timeline>div>.fas {
        background-color: #adb5bd;
        border-radius: 50%;
        font-size: 16px;
        height: 30px;
        left: 18px;
        line-height: 30px;
        position: absolute;
        text-align: center;
        top: 0;
        width: 30px;
        color: #fff;
    }

    .timeline>.time-label>span {
        border-radius: 4px;
        background-color: #fff;
        color: white;
        display: inline-block;
        font-weight: 600;
        padding: 5px;
    }

    .timeline-footer .btn {
        margin-right: 5px;
    }

    .resume-content {
        position: relative;
    }

    .show-more,
    .show-less {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
    }

    .show-more:hover,
    .show-less:hover {
        text-decoration: underline;
    }

    /* Card Modernization */
    .card {
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Card Header Styling */
    .card-header {
        background: linear-gradient(to right, #007bff, #0056b3);
        color: white;
        font-weight: bold;
        border-radius: 12px 12px 0 0;
        padding: 15px;
        text-align: center;
    }

    .card-header a {
        color: white !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }


    /* Buttons */
    .btn {
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
    }

    /* Add animation to the card */
    .animated-card {
        animation: fadeInUp 1s ease-in-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Add hover effect */
    .animated-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Fade In and Slide Up Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pokja-list {
        margin-top: -15px;
        padding-left: 20px;
        list-style-type: none;
    }

    .pokja-list li {
        margin-bottom: 5px;
        line-height: 1.5;
    }

    /* Responsive Design */
    @media (max-width: 767px) {
        .pokja-list {
            padding-left: 10px; /* Mengurangi padding pada perangkat mobile */
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .pokja-list {
            padding-left: 15px; /* Sedikit padding pada tablet */
        }
    }

    @media (min-width: 992px) {
        .pokja-list {
            padding-left: 20px; /* Padding untuk perangkat besar seperti laptop/desktop */
        }
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set an interval to check every second
        setInterval(() => {
            document.querySelectorAll('.created-at-timestamp').forEach(el => {
                const createdAt = parseInt(el.getAttribute('data-timestamp'));
                const currentTime = new Date().getTime();
                const timeDifference = (currentTime - createdAt) / 1000; // in seconds

                // If more than 5 minutes (300 seconds) has passed, hide edit and delete buttons
                if (timeDifference > 60) {
                    const itemId = el.closest('.timeline-footer').id.split('-').pop();
                    document.getElementById(`edit-btn-${itemId}`)?.remove();
                    document.getElementById(`delete-form-${itemId}`)?.remove();
                }
            });
        }, 1000); // Check every second

        $('.show-more').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $(this).closest('.resume-content').find('.resume-preview').hide();
            $(this).closest('.resume-content').find('.resume-full-' + id).show();
        });

        $('.show-less').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $(this).closest('.resume-content').find('.resume-full-' + id).hide();
            $(this).closest('.resume-content').find('.resume-preview').show();
        });
    });
</script>
@endpush