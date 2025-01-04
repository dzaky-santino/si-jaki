@extends('layouts.layout_main')

@section('title', 'Edit Data Histori Perguruan Tinggi')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Edit Data Histori Perguruan Tinggi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Beranda</a></div>
            <div class="breadcrumb-item"><a href="{{ route('data-histori-pt.index')}}">Data Histori Perguruan Tinggi</a></div>
            <div class="breadcrumb-item">Edit Data Histori Perguruan Tinggi</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header gradient-header">
                        <h4>Edit Data Histori Perguruan Tinggi</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('data-histori-pt.update', $data->uuid) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="kode_pt">Kode Perguruan Tinggi<span class="text-danger">*</span></label>
                                <input type="text" name="kode_pt" class="form-control modern-input" id="kode_pt" value="{{ $data->kode_pt }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nama_pt">Nama Perguruan Tinggi<span class="text-danger">*</span></label>
                                <input type="text" name="nama_pt" class="form-control modern-input" id="nama_pt" value="{{ $data->nama_pt }}" required>
                            </div>

                            <div class="form-group">
                                <label for="status_pt">Status<span class="text-danger">*</span></label>
                                <select name="status_pt" class="form-control modern-select" id="status_pt" onchange="toggleKeteranganInput()" required>
                                    <option value="Aktif" {{ $data->status_pt == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tutup" {{ $data->status_pt == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                                    <option value="Merger" {{ $data->status_pt == 'Merger' ? 'selected' : '' }}>Merger</option>
                                    <option value="Berubah Bentuk" {{ $data->status_pt == 'Berubah Bentuk' ? 'selected' : '' }}>Berubah Bentuk</option>
                                    <option value="Perubahan Nama" {{ $data->status_pt == 'Perubahan Nama' ? 'selected' : '' }}>Perubahan Nama</option>
                                    <option value="Pindah Lokasi" {{ $data->status_pt == 'Pindah Lokasi' ? 'selected' : '' }}>Pindah Lokasi</option>
                                </select>
                            </div>

                            <div class="form-group" id="keteranganForm" style="display: none;">
                                <label for="keterangan">Keterangan<span class="text-danger">*</span></label>
                                <textarea class="form-control modern-textarea @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" rows="4">{{ $data->keterangan }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-action">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('data-histori-pt.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    function toggleKeteranganInput() {
        const status = document.getElementById('status_pt').value;
        const keteranganForm = document.getElementById('keteranganForm');
        if (status !== 'Aktif' && status !== '') {
            keteranganForm.style.display = 'block';
        } else {
            keteranganForm.style.display = 'none';
        }
    }

    // Menjalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        toggleKeteranganInput();
    });
</script>
@endpush
