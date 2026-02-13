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
                        surface: '#ffffff',
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        body { background-color: #fdfdff; background-image: radial-gradient(#e5e7eb 0.5px, transparent 0.5px); background-size: 24px 24px; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }

        .sidebar-item { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-item:hover { transform: translateX(8px); }
        
        .active-link {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
            color: white !important;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .custom-shadow { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.03), 0 10px 10px -5px rgba(0, 0, 0, 0.02); }
    </style>
</head>
<body class="font-sans text-slate-700 overflow-x-hidden">

    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-100 shadow-2xl lg:shadow-none">
        <div class="flex flex-col h-full p-6">
            <div class="flex items-center gap-3 px-2 mb-10">
               
                <span class="text-xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 uppercase">
                    PENGADUAN<span class="text-primary font-black">APLIKASI</span>
                </span>
            </div>

            <nav class="flex-1 space-y-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-4">Core Panel</p>
                
                {{-- <a href="/dashboard" class="sidebar-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 font-semibold hover:bg-slate-50 {{ Request::is('dashboard') ? 'active-link' : '' }}">
                    <i class="bi bi-grid-fill text-lg"></i> Dashboard
                </a> --}}

                <a href="{{ route('aspirasi.create') }}" class="sidebar-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 font-semibold hover:bg-slate-50 {{ Request::is('aspirasi/create') ? 'active-link' : '' }}">
                    <i class="bi bi-plus-circle-dotted text-lg"></i> Ajukan Aspirasi
                </a>

                <a href="{{ route('aspirasi.history') }}" class="sidebar-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 font-semibold hover:bg-slate-50 {{ Request::is('aspirasi/history') ? 'active-link' : '' }}">
                    <i class="bi bi-stack text-lg"></i> Riwayat Progress
                </a>

                <div class="pt-8">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-4">Administrator</p>
                    <a href="{{ route('admin.aspirasi.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-500 font-semibold hover:bg-slate-50 {{ Request::is('admin*') ? 'active-link' : '' }}">
                        <i class="bi bi-shield-lock-fill text-lg"></i> Manage Feedback
                    </a>
                </div>
            </nav>

            <div class="mt-auto p-4 bg-slate-50 rounded-3xl border border-slate-100 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">Sesi Aktif</p>
                </div>
                <a href="#" class="text-red-400 hover:text-red-600 transition-colors">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                </a>
            </div>
        </div>
    </aside>

    <div class="lg:ml-72 min-h-screen flex flex-col">
        
        <header class="h-24 px-8 flex items-center justify-between sticky top-0 z-40 bg-white/60 backdrop-blur-xl border-b border-slate-100/50">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden h-10 w-10 flex items-center justify-center rounded-xl bg-white shadow-sm border border-slate-200">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Selamat Datang</h2>
                    <p class="text-xs font-medium text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-black text-slate-800 uppercase tracking-tighter">Verified Account</span>
                    <span class="text-[10px] text-emerald-500 font-bold flex items-center justify-end gap-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span> Online
                    </span>
                </div>
                <div class="h-12 w-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center p-1">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'A' }}&background=6366f1&color=fff&rounded=true" class="rounded-xl" alt="avatar">
                </div>
            </div>
        </header>

        <main class="p-6 lg:p-10 flex-1">
            <div class="max-w-7xl mx-auto">
                
                @if(Request::is('dashboard'))
                <div class="relative overflow-hidden mb-10 p-8 rounded-[2.5rem] bg-gradient-to-br from-darkNavy to-slate-800 text-white shadow-2xl shadow-indigo-200">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-extrabold mb-2 italic">Dashboard Overview</h3>
                        <p class="text-indigo-100/80 max-w-md text-sm leading-relaxed">Pantau perkembangan aspirasi Anda secara real-time melalui sistem integrasi terpusat kami.</p>
                    </div>
                    <div class="absolute top-[-50px] right-[-50px] h-64 w-64 bg-primary/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-[-20px] left-[20%] h-32 w-32 bg-accent/20 rounded-full blur-2xl"></div>
                </div>
                @endif

                <div class="glass-card rounded-[2.5rem] p-8 lg:p-10 transition-all duration-500">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="p-10 text-center">
            <p class="text-xs font-bold text-slate-300 uppercase tracking-[4px]">&copy; 2024 Sarana Developer Team</p>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>