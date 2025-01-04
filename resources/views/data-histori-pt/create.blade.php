@extends('layouts.layout_main')

@section('title', 'Tambah Data Histori PT')

@section('content')

<div class="section-header">
    <h1>Tambah Data Histori Perguruan Tinggi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
        <div class="breadcrumb-item"><a href="{{ route('data-histori-pt.index') }}">Data Histori PT</a></div>
        <div class="breadcrumb-item">Tambah Data Histori PT</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header gradient-header">
                    <h4>Tambah Data Histori Perguruan Tinggi</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('data-histori-pt.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="inputMode">Pilih Metode Input Data</label>
                            <select id="inputMode" class="form-control" name="input_mode" onchange="toggleInputMode()">
                                <option value="upload">Upload Excel</option>
                                <option value="manual">Isi Data Manual</option>
                            </select>
                        </div>

                        <!-- Upload Excel Form -->
                        <div id="uploadForm">
                            <div class="form-group">
                                <label>
                                    Upload File Excel
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" accept=".xlsx,.xls">
                                    <label class="custom-file-label" for="file">Pilih file</label>
                                    @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Format: XLS, XLSX, Maksimal: 2MB</small>
                            </div>
                        </div>

                        <!-- Manual Entry Form -->
                        <div id="manualForm" style="display: none;">
                            <div class="form-group">
                                <label for="kode_pt">Kode Perguruan Tinggi<span class="text-danger">*</span></label>
                                <input type="text" name="kode_pt" class="form-control @error('kode_pt') is-invalid @enderror" id="kode_pt" value="{{ old('kode_pt') }}">
                                @error('kode_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_pt">Nama Perguruan Tinggi<span class="text-danger">*</span></label>
                                <input type="text" name="nama_pt" class="form-control @error('nama_pt') is-invalid @enderror" id="nama_pt" value="{{ old('nama_pt') }}">
                                @error('nama_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status_pt">Status<span class="text-danger">*</span></label>
                                <select name="status_pt" class="form-control @error('status_pt') is-invalid @enderror" id="status_pt" onchange="toggleKeteranganInput()">
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif" {{ old('status_pt') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tutup" {{ old('status_pt') == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                                    <option value="Merger" {{ old('status_pt') == 'Merger' ? 'selected' : '' }}>Merger</option>
                                    <option value="Berubah Bentuk" {{ old('status_pt') == 'Berubah Bentuk' ? 'selected' : '' }}>Berubah Bentuk</option>
                                    <option value="Perubahan Nama" {{ old('status_pt') == 'Perubahan Nama' ? 'selected' : '' }}>Perubahan Nama</option>
                                    <option value="Pindah Lokasi" {{ old('status_pt') == 'Pindah Lokasi' ? 'selected' : '' }}>Pindah Lokasi</option>
                                </select>
                                @error('status_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="keteranganForm" style="display: none;">
                                <label for="keterangan">Keterangan<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" rows="4">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('data-histori-pt.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
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

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleInputMode() {
        const mode = document.getElementById('inputMode').value;
        document.getElementById('uploadForm').style.display = mode === 'upload' ? 'block' : 'none';
        document.getElementById('manualForm').style.display = mode === 'manual' ? 'block' : 'none';
    }

    function toggleKeteranganInput() {
        const status = document.getElementById('status_pt').value;
        const keteranganForm = document.getElementById('keteranganForm');
        if (status !== 'Aktif' && status !== '') {
            keteranganForm.style.display = 'block';
        } else {
            keteranganForm.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleInputMode(); 
        toggleKeteranganInput(); 
    });

    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('.custom-file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                let fileName = this.value.split('\\').pop();
                this.nextElementSibling.classList.add("selected");
                this.nextElementSibling.innerHTML = fileName;
            });
        });
    });
</script>
@endpush
