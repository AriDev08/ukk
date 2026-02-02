@extends('layouts.app')

@section('title', 'Buat Aspirasi Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-3 p-2 me-3">
                    <i class="bi bi-pencil-square fs-4"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">Form Aspirasi Siswa</h4>
                    <p class="text-muted small mb-0">Sampaikan keluhan atau saran mengenai sarana sekolah secara detail.</p>
                </div>
            </div>

            <hr class="mb-4 opacity-50">

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <div class="fw-bold mb-1 text-danger">Terjadi Kesalahan:</div>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-secondary small uppercase">Judul Aspirasi</label>
                        <input type="text" name="title" class="form-control form-control-lg border-2 shadow-none" 
                               placeholder="Contoh: Kerusakan Meja di Kelas X-A" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Kategori</label>
                        <select name="category_id" class="form-select form-control-lg border-2 shadow-none" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Deskripsi Lengkap</label>
                    <textarea name="description" class="form-control border-2 shadow-none" rows="6" 
                              placeholder="Jelaskan secara detail lokasi, kondisi, dan kronologi..." required></textarea>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-semibold text-secondary small">Lampiran Dokumen/Foto (Opsional)</label>
                    <div class="input-group">
                        <input type="file" name="attachment" class="form-control border-2 shadow-none" id="inputGroupFile02">
                        <label class="input-group-text bg-light border-2" for="inputGroupFile02">Upload</label>
                    </div>
                    <div class="form-text text-muted small">
                        Format yang didukung: JPG, PNG, atau PDF (Maks. 2MB)
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <button type="reset" class="btn btn-link text-decoration-none text-muted fw-medium">
                        Bersihkan Form
                    </button>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                        Kirim Aspirasi <i class="bi bi-send-fill ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk memoles form control */
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    }
    
    .form-label {
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .form-control-lg, .form-select-lg {
        font-size: 1rem;
        border-radius: 8px;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }
</style>
@endsection