<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Aspirasi')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#4f46e5',
                        accent: '#f43f5e',
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fdfdff;
            background-image: radial-gradient(#e5e7eb 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.6);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .sidebar-item {
            transition: all .2s ease;
        }
        .sidebar-item:hover { 
            transform: translateX(6px);
        }
        .active-link {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white !important;
        }
    </style>
</head>

<body class="font-sans text-slate-700">

<div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white z-50 transform -translate-x-full lg:translate-x-0 transition duration-300 border-r">
    <div class="flex flex-col h-full p-6">

        <div class="mb-10 text-xl font-extrabold uppercase">
            PENGADUAN<span class="text-primary">APP</span>
        </div>

        <nav class="flex-1 space-y-2">

            {{-- ================= S I S W A ================= --}}
            @if(auth()->user()->role === 'siswa')

                <p class="text-xs text-slate-400 uppercase font-bold">Core</p>

                <a href="{{ route('aspirasi.create') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('aspirasi/create') ? 'active-link' : '' }}">
                    <i class="bi bi-plus-circle"></i> Ajukan Aspirasi
                </a>

                <a href="{{ route('aspirasi.history') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('aspirasi/history') ? 'active-link' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>

            @endif


            {{-- ================= A D M I N ================= --}}
            @if(auth()->user()->role === 'admin')

                <p class="text-xs text-slate-400 uppercase font-bold">Admin</p>

                <a href="{{ route('admin.aspirasi.index') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('admin/aspirasi*') ? 'active-link' : '' }}">
                    <i class="bi bi-shield-check"></i> Manage Aspirasi
                </a>

                <a href="{{ route('admin.siswa.index') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('admin/siswa*') ? 'active-link' : '' }}">
                    <i class="bi bi-people"></i> Data Siswa
                </a>

                <a href="{{ route('admin.kelas.index') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('admin/kelas*') ? 'active-link' : '' }}">
                    <i class="bi bi-door-open"></i> Data Kelas
                </a>

                <a href="{{ route('admin.jurusan.index') }}"
                   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('admin/jurusan*') ? 'active-link' : '' }}">
                    <i class="bi bi-diagram-3"></i> Data Jurusan
                </a>

                <a href="{{ url('admin/categories') }}"
   class="sidebar-item flex gap-3 px-4 py-3 rounded-xl font-semibold hover:bg-slate-100 {{ Request::is('admin/categories*') ? 'active-link' : '' }}">
    <i class="bi bi-tags"></i> Categories
</a>


            @endif

        </nav>

      
        <div class="relative">
            <button onclick="toggleProfile()" class="w-full flex items-center gap-3 p-3 bg-slate-50 rounded-xl border">
                <div class="h-9 w-9 rounded-full bg-primary/20 flex items-center justify-center font-bold text-primary">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div class="flex-1 text-left">
                    <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <i class="bi bi-chevron-down"></i>
            </button>

            <div id="profileMenu" class="hidden absolute bottom-14 left-0 w-full bg-white border rounded-xl shadow-xl overflow-hidden">

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.impersonate.page') }}"
                   class="block px-4 py-3 hover:bg-slate-100 text-sm">
                    <i class="bi bi-person-bounding-box mr-2"></i>
                    Login sebagai siswa
                </a>
                @endif

                @if(session()->has('impersonator'))
                <form action="{{ route('admin.impersonate.stop') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-4 py-3 hover:bg-yellow-100 text-sm text-yellow-700">
                        <i class="bi bi-arrow-counterclockwise mr-2"></i>
                        Kembali ke Admin
                    </button>
                </form>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left px-4 py-3 hover:bg-red-100 text-red-600 text-sm">
                        <i class="bi bi-box-arrow-right mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</aside>

<div class="lg:ml-72 min-h-screen flex flex-col">

<header class="h-20 px-8 flex items-center justify-between bg-white/80 backdrop-blur border-b">
    <button onclick="toggleSidebar()" class="lg:hidden h-10 w-10 border rounded-lg">
        <i class="bi bi-list"></i>
    </button>

    @if(session()->has('impersonator'))
    <div class="text-sm bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full">
        Sedang login sebagai <b>{{ auth()->user()->name }}</b>
    </div>
    @endif
</header>

<main class="p-6 lg:p-10 flex-1">
    <div class="glass-card rounded-3xl p-8">
        @yield('content')
    </div>
</main>

<footer class="p-6 text-center text-xs text-slate-400">
    &copy; 2024 Sarana Developer Team
</footer>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
function toggleProfile() {
    document.getElementById('profileMenu').classList.toggle('hidden');
}
</script>

</body>
</html>
