@extends('layouts.layout_main')

@section('title', 'User Management')

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
    }

    table.modern-table th:nth-child(2) {
        color: #ffffff;
    }

    table.modern-table th:nth-child(3) {
        color: #ffffff;
    }

    table.modern-table th:nth-child(4) {
        color: #ffffff;
    }

    table.modern-table th:nth-child(5) {
        color: #ffffff;
    }
    table.modern-table th:nth-child(6) {
        color: #ffffff;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        table.modern-table th {
            font-size: 12px;
            /* Adjust font size for smaller screens */
        }
    }

    /* Centered Button Styling */
    .centered-button {
        display: inline-block;
        margin: 0 auto;
        text-align: center;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 25px;
        background: linear-gradient(120deg, #007bff, #0056b3);
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .centered-button:hover {
        background: linear-gradient(120deg, #0056b3, #003d73);
        transform: scale(1.05);
        color: #fff;
    }

    .btn-sm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        /* Adds space between icon and text */
        font-size: 14px;
        /* Small font size */
        padding: 6px 10px;
        /* Adjust padding for compact buttons */
        border-radius: 4px;
        /* Slightly rounded corners */
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: scale(1.05);
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }
</style>
<div class="section-header">
    <h1>Data Users</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
        <div class="breadcrumb-item">Data Users</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <a href="{{ route('user.create') }}" class="btn btn-primary centered-button">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </h4>
                    <div class="card-header-action">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                id="searchInput">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table modern-table table-striped" id="sortable-table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-th"></i>
                                    </th>
                                    <th>Tim Kerja</th>
                                    <th>Username</th>
                                    <th>Akses</th>
                                    <th>Login Terakhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($result as $user)
                                <tr class="list-item" data-pokja="{{ $user->pokja }}" data-akses="{{ $user->akses }}">
                                    <td>
                                        <div class="sort-handler">
                                            <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $user->pokja }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->akses }}</td>
                                    <td>{{ $user->last_login ? $user->last_login->format('d-m-Y | H:i') : 'Tidak Pernah' }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('user.edit', $user->uuid) }}" class="btn btn-warning btn-sm" title="Edit Data" data-toggle="tooltip">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                            
                                       <!-- Delete Button -->
                                        @if ($user->akses !== 'Admin') <!-- Hanya tampilkan jika akses bukan "admin" -->
                                            <form action="{{ route('user.destroy', $user->uuid) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus Data"
                                                    data-toggle="tooltip">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('stisla/dist/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    // Implementasi sortable table menggunakan jQuery UI
    $("#sortable-table tbody").sortable({
        handle: '.sort-handler',
        update: function (event, ui) {
            console.log("Updated sorting"); // Implementasi tambahan bisa diterapkan di sini
        }
    });

    // Fitur pencarian otomatis
    document.getElementById('searchInput').addEventListener('input', function() {
        var input = this.value.toLowerCase();
        var listItems = document.querySelectorAll('.list-item');

        listItems.forEach(function(item) {
            var pokja = item.getAttribute('data-pokja').toLowerCase();
            var akses = item.getAttribute('data-akses').toLowerCase();
            if (pokja.includes(input) || akses.includes(input)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

@if (session('success'))
<script>
    swal({
        title: 'Success!',
        text: '{{ session("success") }}',
        icon: 'success',
        button: 'OK',
    });
</script>
@elseif (session('error'))
<script>
    swal({
        title: 'Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        button: 'OK',
    });
</script>
@endif
@endpush

@push('scripts')
<script src="{{ asset('stisla/dist/assets/modules/sweetalert/sweetalert.min.js') }}"></script>
<script>
    function confirmDelete(userId) {
        swal({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Batal',
                    value: null,
                    visible: true,
                    className: 'btn btn-secondary',
                    closeModal: true,
                },
                confirm: {
                    text: 'Ya, Hapus!',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush