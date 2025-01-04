@extends('layouts.layout_main')

@section('title', 'Edit User')

@section('content')
<style>
    /* Card Header Gradient */
    .gradient-header {
        background: linear-gradient(120deg, #007bff, #0056b3);
        color: #ffffff;
        text-align: center;
        padding: 15px;
        border-radius: 15px 15px 0 0;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Modern Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    /* Form Group Styling */
    .form-group label {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        border: 1px solid #ccc;
        border-radius: 25px;
        padding: 12px 15px;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
        font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    .form-group textarea {
        resize: none;
    }

    .custom-file-label {
        border-radius: 25px;
        padding: 12px 15px;
    }

    .form-text {
        font-size: 12px;
        color: #888;
    }

    /* Button Styling */
    .btn-primary {
        background: linear-gradient(120deg, #007bff, #0056b3);
        color: #ffffff;
        border: none;
        border-radius: 25px;
        padding: 12px 20px;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: background 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(120deg, #0056b3, #003d73);
        transform: scale(1.05);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: #333;
        border: none;
        border-radius: 25px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: bold;
        transition: background 0.3s, transform 0.3s;
    }

    .btn-secondary:hover {
        background: #e2e6ea;
        transform: scale(1.05);
    }

    /* Responsive Styling */
    @media (max-width: 768px) {

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            font-size: 13px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 15px;
            font-size: 13px;
        }
    }

    .form-control.modern-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="%23000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        background-repeat: no-repeat;
        background-position: right .7em top 50%, 0 0;
        background-size: 1.5em auto, 100%;
        padding-right: 2.5em;
    }

    /* Styling for Modern Date Picker */
    .modern-date-picker {
        border: 1px solid #ffffff;
        border-radius: 25px;
        padding: 12px 15px;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
        font-size: 14px;
    }

    .modern-date-picker:focus {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        outline: none;
    }
</style>
<div class="section-header">
    <h1>Edit User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
        <div class="breadcrumb-item"><a href="{{ route('user.index') }}">Data Users</a></div>
        <div class="breadcrumb-item">Edit User</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header gradient-header">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->uuid) }}" method="POST">
                        @csrf
                        @method('PUT')
                
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        {{-- <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                
                        <div class="form-group">
                            <label>Tim Kerja</label>
                            <input type="text" name="pokja" class="form-control @error('pokja') is-invalid @enderror"
                                value="{{ old('pokja', $user->pokja) }}">
                            @error('pokja')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label>Akses</label>
                            <select name="akses" class="form-control modern-select @error('akses') is-invalid @enderror">
                                <option value="Admin" {{ old('akses', $user->akses) === 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="User" {{ old('akses', $user->akses) === 'User' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('akses')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection