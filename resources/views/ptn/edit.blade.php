@extends('layouts.layout_main')

@section('title', 'Edit Perguruan Tinggi Negeri')

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
</style>
<div class="section-header">
    <h1>Edit Perguruan Tinggi Negeri</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
        <div class="breadcrumb-item"><a href="{{ route('ptn.index') }}">Data Perguruan Tinggi Negeri</a></div>
        <div class="breadcrumb-item">Edit Perguruan Tinggi Negeri</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header gradient-header">
                    <h4>Edit Perguruan Tinggi Negeri</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('ptn.update', $perguruantingginegeri->uuid) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="form-group">
                            <label>Kode PT</label>
                            <input type="text" name="kode_pt"
                                class="form-control @error('kode_pt') is-invalid @enderror"
                                value="{{ old('kode_pt', $perguruantingginegeri->kode_pt) }}" required>
                            @error('kode_pt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label>Nama PT</label>
                            <input type="text" name="nama_pt"
                                class="form-control modern-select @error('nama_pt') is-invalid @enderror"
                                value="{{ old('nama_pt', $perguruantingginegeri->nama_pt) }}" required>
                            @error('nama_pt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('ptn.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection