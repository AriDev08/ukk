<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Informasi Aspirasi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #2563eb;
            --dark-navy: #0f172a;
            --bg-light: #f8fafc;
            --text-muted: #64748b;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-light);
            color: #1e293b;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--dark-navy);
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-label {
            padding: 20px 20px 10px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: #94a3b8;
            padding: 12px 25px;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .sidebar a.active {
            background: var(--primary-color);
            color: #fff;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: #fff;
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
        }

        .content-body {
            padding: 40px;
            flex: 1;
        }

        /* Elements */
        .card-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--dark-navy);
        }

        .logout-btn {
            color: #ef4444 !important;
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        @media (max-width: 768px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        SARANA <span style="color: var(--primary-color);">SYSTEM</span>
    </div>
    
    <div class="nav-label">Menu Utama</div>
    <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i> Dashboard
    </a>
    <a href="{{ route('aspirasi.create') }}" class="{{ Request::is('aspirasi/create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Buat Aspirasi
    </a>
    <a href="{{ route('aspirasi.history') }}" class="{{ Request::is('aspirasi/history') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat Pengajuan
    </a>

    <div class="nav-label">Administrator</div>
    <a href="{{ route('admin.aspirasi.index') }}" class="{{ Request::is('admin*') ? 'active' : '' }}">
        <i class="bi bi-chat-left-dots"></i> Manajemen Umpan Balik
    </a>

    <a href="#" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i> Keluar Sesi
    </a>
</aside>

<div class="main-wrapper">
    <header class="top-navbar">
        <div class="page-info">
            <span class="text-muted fw-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
        
        <div class="user-profile">
            <div class="text-end d-none d-sm-block">
                <div class="fw-bold" style="font-size: 0.9rem; line-height: 1;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <small class="text-muted" style="font-size: 0.75rem;">Sesi Aktif</small>
            </div>
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="content-body">
        <div class="card-custom">
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>