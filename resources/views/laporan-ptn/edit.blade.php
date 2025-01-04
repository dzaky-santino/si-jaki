@extends('layouts.layout_main')

@section('title', 'Edit Kegiatan')

@section('content')
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

<section class="section">
    <div class="section-header">
        <h1>Edit Kegiatan - {{ $ptn->nama_pt }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header gradient-header">
                        <h4>Edit Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan-ptn.update', $laporan->uuid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Display Perguruan Tinggi as read-only -->
                            <div class="form-group">
                                <label>Perguruan Tinggi</label>
                                <input type="text" class="form-control modern-input" value="{{ $ptn->nama_pt }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                                <input type="text" id="tanggal_kegiatan" class="form-control modern-date-picker"
                                    name="tanggal_kegiatan" value="{{ $laporan->tanggal_kegiatan }}" required>
                            </div>

                            <!-- Include Flatpickr CSS -->
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

                            <!-- Include Flatpickr JS -->
                            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

                            <script>
                                // Initialize Flatpickr
                                document.addEventListener("DOMContentLoaded", function () {
                                    flatpickr("#tanggal_kegiatan", {
                                        dateFormat: "Y-m-d", // Database-friendly format
                                        defaultDate: "{{ $laporan->tanggal_kegiatan }}", // Pre-fill existing value
                                        altInput: true, // User-friendly display format
                                        altFormat: "F j, Y", // e.g., January 1, 2024
                                        locale: "id", // Optional: Set to Indonesian locale
                                        disableMobile: "true" // Force desktop version on mobile
                                    });
                                });
                            </script>

                            <div class="form-group">
                                <label>Tempat Kegiatan</label>
                                <input type="text" class="form-control modern-input" name="tempat_kegiatan"
                                    value="{{ $laporan->tempat_kegiatan }}" required>
                            </div>

                            <div class="form-group">
                                <label>Jenis Kegiatan</label>
                                <select name="jenis_kegiatan" class="form-control modern-select" required>
                                    <option value="Rapat/Audiensi" {{ $laporan->jenis_kegiatan == 'Rapat/Audiensi' ? 'selected' : '' }}>Rapat/Audiensi</option>
                                    <option value="Visitasi" {{ $laporan->jenis_kegiatan == 'Visitasi' ? 'selected' : '' }}>Visitasi</option>
                                    <option value="Monitoring & Evaluasi" {{ $laporan->jenis_kegiatan == 'Monitoring & Evaluasi' ? 'selected' : '' }}>Monitoring & Evaluasi</option>
                                    <option value="Aduan/Laporan" {{ $laporan->jenis_kegiatan == 'Aduan/Laporan' ? 'selected' : '' }}>Aduan/Laporan</option>
                                    <option value="Teguran/Sanksi" {{ $laporan->jenis_kegiatan == 'Teguran/Sanksi' ? 'selected' : '' }}>Teguran/Sanksi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Dokumen Notula/Hasil Pembinaan (PDF) Maksimal: 2MB</label>
                                <input type="file" class="form-control modern-file-input" name="dokumen_notula"
                                    accept=".pdf">
                                @if($laporan->dokumen_notula)
                                <small>File Saat Ini: <a href="{{ asset('storage/' . $laporan->dokumen_notula) }}"
                                        target="_blank">Lihat Notula</a></small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Surat/Undangan (PDF) Maksimal: 2MB</label>
                                <input type="file" class="form-control modern-file-input" name="dokumen_undangan"
                                    accept=".pdf">
                                @if($laporan->dokumen_undangan)
                                <small>File Saat Ini: <a href="{{ asset('storage/' . $laporan->dokumen_undangan) }} "
                                        target="_blank">Lihat Undangan</a></small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="pokja">Lingkup Tim Kerja<span class="text-danger">*</span></label>
                                <div class="row">
                                    @foreach($pokjaList as $pokja)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <!-- Periksa apakah checkbox ini termasuk dalam daftar yang dipilih -->
                                            <input class="form-check-input" type="checkbox" name="pokja[]" value="{{ $pokja }}"
                                                id="pokja_{{ $loop->index }}"
                                                {{ in_array(trim($pokja), array_map('trim', explode(';', $laporan->pokja))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pokja_{{ $loop->index }}">
                                                {{ $pokja }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="resume">Ringkasan <span class="text-danger">*</span></label>
                                <textarea id="resume"
                                    class="form-control modern-textarea @error('resume') is-invalid @enderror"
                                    name="resume" rows="4" maxlength="500" oninput="updateCharCount(this)"
                                    required>{{ $laporan->resume }}</textarea>
                                <small class="form-text text-muted">Karakter: <span id="charCount">{{ strlen($laporan->resume) }}/500</span></small>
                                @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-action">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('laporan-ptn.show', $ptn->uuid) }}" class="btn btn-secondary">
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