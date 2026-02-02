@extends('layouts.app')

@section('title', 'Manajemen Aspirasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Daftar Aspirasi Siswa</h4>
            <p class="text-muted small mb-0">Kelola dan tindak lanjuti setiap laporan sarana dari siswa.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3">
                <i class="bi bi-download me-1"></i> Ekspor Data
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
                <div class="text-muted small fw-medium">Total Masuk</div>
                <div class="h4 fw-bold mb-0">{{ $items->total() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
                <div class="text-muted small fw-medium text-warning">Perlu Diproses</div>
                <div class="h4 fw-bold mb-0">{{ $items->where('status', 'pending')->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
                <div class="text-muted small fw-medium text-success">Selesai</div>
                <div class="h4 fw-bold mb-0">{{ $items->where('status', 'done')->count() }}</div>
            </div>
        </div>
    </div>

    <div class="table-responsive bg-white rounded-3 border">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 border-0 text-secondary small uppercase fw-bold">Waktu Masuk</th>
                    <th class="py-3 border-0 text-secondary small uppercase fw-bold">Pengirim</th>
                    <th class="py-3 border-0 text-secondary small uppercase fw-bold">Subjek Aspirasi</th>
                    <th class="py-3 border-0 text-secondary small uppercase fw-bold text-center">Status</th>
                    <th class="pe-4 py-3 border-0 text-secondary small uppercase fw-bold text-end">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $row)
                <tr>
                    <td class="ps-4 py-3 border-bottom">
                        <div class="text-dark fw-medium">{{ $row->created_at->format('d/m/Y') }}</div>
                        <small class="text-muted">{{ $row->created_at->format('H:i') }} WIB</small>
                    </td>
                    <td class="py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($row->user->name, 0, 1)) }}
                            </div>
                            <div class="fw-semibold text-dark">{{ $row->user->name }}</div>
                        </div>
                    </td>
                    <td class="py-3 border-bottom">
                        <div class="text-dark">{{ $row->title }}</div>
                        <small class="badge bg-light text-muted border-0 fw-normal">ID: #ASP-{{ $row->id }}</small>
                    </td>
                    <td class="py-3 border-bottom text-center">
                        @php
                            $statusStyles = [
                                'pending' => 'bg-warning text-dark',
                                'process' => 'bg-primary text-white',
                                'done'    => 'bg-success text-white'
                            ];
                        @endphp
                        <span class="badge {{ $statusStyles[$row->status] ?? 'bg-secondary' }} px-3 py-2 rounded-pill" style="font-size: 0.75rem; min-width: 85px;">
                            {{ strtoupper($row->status) }}
                        </span>
                    </td>
                    <td class="pe-4 py-3 border-bottom text-end">
                        <a href="{{ route('admin.aspirasi.show', $row->id) }}" class="btn btn-white border shadow-sm btn-sm px-3 fw-medium">
                            Tinjau Laporan <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <p class="text-muted mb-0">Belum ada data aspirasi yang masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>

<style>
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    
    .btn-white {
        background: #fff;
        color: #475569;
    }

    .btn-white:hover {
        background: #f8fafc;
        color: var(--primary-color);
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #fcfcfd;
    }

    /* Memperhalus pagination */
    .pagination {
        justify-content: center;
    }
</style>
@endsection