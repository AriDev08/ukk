@extends('layouts.app')

@section('title', 'Histori Aspirasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Histori Aspirasi Saya</h4>
            <p class="text-muted small mb-0">Pantau status dan perkembangan laporan yang telah Anda kirimkan.</p>
        </div>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Buat Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle" style="border-collapse: separate; border-spacing: 0 8px;">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3 border-0 text-secondary small uppercase fw-bold" style="width: 150px;">Tanggal</th>
                    <th class="border-0 text-secondary small uppercase fw-bold">Judul Aspirasi</th>
                    <th class="border-0 text-secondary small uppercase fw-bold">Kategori</th>
                    <th class="border-0 text-secondary small uppercase fw-bold text-center">Status</th>
                    <th class="pe-3 border-0 text-secondary small uppercase fw-bold text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $row)
                <tr class="bg-white shadow-sm rounded-3">
                    <td class="ps-3 py-3 border-0">
                        <span class="text-dark fw-medium">{{ $row->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="py-3 border-0">
                        <div class="fw-bold text-dark">{{ $row->title }}</div>
                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                            {{ Str::limit($row->description, 50) }}
                        </small>
                    </td>
                    <td class="py-3 border-0">
                        <span class="badge bg-light text-dark border fw-normal px-3 py-2">
                            {{ $row->category->name }}
                        </span>
                    </td>
                    <td class="py-3 border-0 text-center">
                        @php
                            $statusClass = [
                                'pending' => 'bg-warning-subtle text-warning-emphasis border-warning',
                                'process' => 'bg-primary-subtle text-primary-emphasis border-primary',
                                'done'    => 'bg-success-subtle text-success-emphasis border-success'
                            ][$row->status] ?? 'bg-secondary-subtle';
                        @endphp
                        <span class="badge border px-3 py-2 {{ $statusClass }}" style="min-width: 90px; font-weight: 600;">
                            {{ strtoupper($row->status) }}
                        </span>
                    </td>
                    <td class="pe-3 py-3 border-0 text-end">
                        @if($row->attachment_path)
                            <a href="{{ asset('storage/'.$row->attachment_path) }}" 
                               target="_blank" 
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-paperclip me-1"></i> Lampiran
                            </a>
                        @else
                            <span class="text-muted small">Tanpa Dokumen</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 border-0">
                        <div class="py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">Belum ada histori aspirasi yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <p class="small text-muted mb-0">
            Menampilkan {{ $items->firstItem() ?? 0 }} sampai {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
        </p>
        <div class="custom-pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>

<style>
    /* Menghilangkan garis default tabel untuk tampilan card-style */
    .table > :not(caption) > * > * {
        box-shadow: none;
    }
    
    .table thead th {
        padding: 15px 10px;
        letter-spacing: 0.5px;
    }

    /* Efek hover pada baris tabel */
    tbody tr {
        transition: all 0.2s ease;
        border-radius: 8px;
    }

    tbody tr:hover {
        transform: scale(1.005);
        background-color: #f8fafc !important;
    }

    .badge {
        letter-spacing: 0.3px;
    }

    /* Penyesuaian pagination Bootstrap */
    .pagination {
        margin-bottom: 0;
        gap: 5px;
    }

    .page-link {
        border-radius: 6px !important;
        border: none;
        color: var(--dark-navy);
        font-weight: 500;
        padding: 8px 16px;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
    }
</style>
@endsection