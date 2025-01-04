@extends('layouts.layout_main')

@section('title', 'Data Laporan PTS')

@section('content')
<style>
    /* General Table Header Styling */
    table.modern-table th {
        background: linear-gradient(120deg, #007bff, #007bff);
        /* Gradient background */
        color: #ffffff;
        /* White font color for contrast */
        text-transform: uppercase;
        /* Uppercase for modern look */
        font-weight: bold;
        /* Bold text */
        font-size: 14px;
        /* Font size adjustment */
        padding: 10px 15px;
        /* Padding for spacing */
        border-bottom: 2px solid #0056b3;
        /* Add bottom border */
        text-align: left;
        /* Align text to the left */
    }

    /* Specific Font Colors for Each Column */
    table.modern-table th:nth-child(1) {
        color: #ffffff;
        /* Red font for column # */
    }

    table.modern-table th:nth-child(2) {
        color: #ffffff;
        /* Orange font for column Kode PT */
    }

    table.modern-table th:nth-child(3) {
        color: #ffffff;
        /* Blue font for column Nama PT */
    }

    table.modern-table th:nth-child(4) {
        color: #ffffff;
        /* Green font for column Aksi */
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        table.modern-table th {
            font-size: 12px;
            /* Adjust font size for smaller screens */
        }
    }
</style>
<section class="section">
    <div class="section-header">
        <h1>Data Laporan PTS</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
            <div class="breadcrumb-item">Laporan</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="text-center">
                            <span class="text-muted mr-2">Rows per page:</span>
                            <select class="form-control d-inline-block w-auto" id="pageSize" onchange="changePageSize()"
                                style="border-radius: 0; padding: 10px;">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="card-header-action">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search..."
                                onkeyup="searchTable()">
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode PT</th>
                                        <th>Nama PT</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTable">
                                    @foreach($laporan_list as $key => $pt)
                                    <tr class="table-row">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pt->kode_pt }}</td>
                                        <td>{{ $pt->nama_pt }}</td>
                                        <td>
                                            <a href="{{ route('laporan-pts.create', $pt->uuid) }}"
                                                class="btn btn-success btn-sm" title="Tambah Kegiatan">
                                                <i class="fas fa-plus"></i> Tambah Kegiatan
                                            </a>
                                            <a href="{{ route('laporan-pts.show', $pt->uuid) }}"
                                                class="btn btn-primary btn-sm" title="Lihat Histori">
                                                <i class="fas fa-history"></i> Lihat Histori
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-6 text-md-right text-center">
                                <nav class="d-inline-block">
                                    <ul class="pagination mb-0" id="pagination">
                                        <!-- Pagination buttons will be dynamically added here -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    let pageSize = parseInt(document.getElementById('pageSize').value);

    function changePageSize() {
        pageSize = parseInt(document.getElementById('pageSize').value);
        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const tableRows = Array.from(document.querySelectorAll('#dataTable tr'));
        const totalRows = tableRows.length;
        const totalPages = Math.ceil(totalRows / pageSize);
        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;

        tableRows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? '' : 'none';
        });

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        const maxVisiblePages = 5;

        // Tombol Previous
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item');
        if (currentPage === 1) prevItem.classList.add('disabled');
        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevLink.onclick = function(event) {
            event.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        };
        prevItem.appendChild(prevLink);
        pagination.appendChild(prevItem);

        // Tombol Halaman
        let startPage = Math.max(currentPage - Math.floor(maxVisiblePages / 2), 1);
        let endPage = Math.min(startPage + maxVisiblePages - 1, totalPages);

        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(endPage - maxVisiblePages + 1, 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const pageItem = document.createElement('li');
            pageItem.classList.add('page-item');
            if (i === currentPage) pageItem.classList.add('active');
            const pageLink = document.createElement('a');
            pageLink.classList.add('page-link');
            pageLink.href = '#';
            pageLink.textContent = i;
            pageLink.onclick = function(event) {
                event.preventDefault();
                currentPage = i;
                renderTable();
            };
            pageItem.appendChild(pageLink);
            pagination.appendChild(pageItem);
        }

        // Tombol Next
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item');
        if (currentPage === totalPages) nextItem.classList.add('disabled');
        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextLink.onclick = function(event) {
            event.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        };
        nextItem.appendChild(nextLink);
        pagination.appendChild(nextItem);
    }

    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.querySelectorAll('#dataTable tr');

        tableRows.forEach(row => {
            const kodePT = row.children[1].textContent.toLowerCase();
            const namaPT = row.children[2].textContent.toLowerCase();
            row.style.display = kodePT.includes(input) || namaPT.includes(input) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderTable();
    });
</script>
@endpush