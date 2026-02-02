@extends('layouts.app')

@section('title', 'Tinjau Aspirasi #' . $aspirasi->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="mb-0 fw-bold">Detail Aspirasi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item text-primary">Admin</li>
                    <li class="breadcrumb-item text-primary">Aspirasi</li>
                    <li class="breadcrumb-item active">#ASP-{{ $aspirasi->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="badge bg-light text-primary border border-primary-subtle mb-2 px-3">
                                {{ $aspirasi->category->name ?? '-' }}
                            </span>
                            <h2 class="fw-bold text-dark">{{ $aspirasi->title }}</h2>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted mb-1">Status Saat Ini</div>
                            @php
                                $statusBadge = [
                                    'pending' => 'bg-warning-subtle text-warning-emphasis border-warning',
                                    'in_progress' => 'bg-primary-subtle text-primary-emphasis border-primary',
                                    'done' => 'bg-success-subtle text-success-emphasis border-success',
                                    'rejected' => 'bg-danger-subtle text-danger-emphasis border-danger'
                                ][$aspirasi->status] ?? 'bg-secondary-subtle';
                            @endphp
                            <span class="badge border px-3 py-2 {{ $statusBadge }}">
                                {{ strtoupper($aspirasi->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4">
                        <div class="row text-center text-sm-start">
                            <div class="col-sm-4 border-end-sm">
                                <label class="small text-muted d-block uppercase fw-semibold mb-1">Pengirim</label>
                                <span class="fw-bold">{{ $aspirasi->user->name }}</span>
                            </div>
                            <div class="col-sm-4 border-end-sm">
                                <label class="small text-muted d-block uppercase fw-semibold mb-1">Tanggal Masuk</label>
                                <span class="fw-bold">{{ $aspirasi->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="col-sm-4">
                                <label class="small text-muted d-block uppercase fw-semibold mb-1">Lampiran</label>
                                @if($aspirasi->attachment_path)
                                    <a href="{{ asset('storage/'.$aspirasi->attachment_path) }}" target="_blank" class="text-decoration-none fw-bold">
                                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-muted fw-bold">Tidak ada</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">Deskripsi Laporan</h6>
                        <p class="text-secondary lh-lg" style="white-space: pre-line;">
                            {{ $aspirasi->description }}
                        </p>
                    </div>

                    <hr class="my-4 opacity-25">

                    <h5 class="fw-bold mb-3">Update Status & Berikan Feedback</h5>
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.aspirasi.feedback', $aspirasi->id) }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Ubah Status</label>
                                <select name="status" class="form-select border-2" required>
                                    <option value="pending" @selected($aspirasi->status=='pending')>
                                        Pending
                                    </option>
                                    <option value="in_progress" @selected($aspirasi->status=='in_progress')>
                                        In Progress
                                    </option>
                                    <option value="done" @selected($aspirasi->status=='done')>
                                        Done
                                    </option>
                                    <option value="rejected" @selected($aspirasi->status=='rejected')>
                                        Rejected
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Catatan untuk Siswa</label>
                                <textarea name="note" class="form-control border-2" rows="4"
                                    placeholder="Tuliskan alasan perubahan status atau instruksi selanjutnya..."
                                    required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                                    Simpan Perubahan <i class="bi bi-save ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark">Riwayat Aktivitas</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        @forelse($aspirasi->histories->sortByDesc('created_at') as $h)
                            <div class="list-group-item border-0 p-3 timeline-item">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="badge bg-light text-dark fw-bold">
                                        {{ strtoupper($h->to_status) }}
                                    </span>
                                    <small class="text-muted">{{ $h->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-dark">{{ $h->note }}</p>
                                <small class="text-muted fs-xs">
                                    {{ $h->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                Belum ada riwayat aktivitas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-end-sm { border-right: 1px solid #e2e8f0; }
@media (max-width: 576px) {
    .border-end-sm {
        border-right: 0;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
}

.uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
.fs-xs { font-size: 0.7rem; }

.timeline-item {
    border-left: 3px solid #e2e8f0 !important;
    margin-left: 15px;
}

.timeline-item:first-child {
    border-left: 3px solid #0d6efd !important;
}

.list-group-item:hover {
    background-color: #f8fafc;
}
</style>
@endsection
