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
<body>
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="glass-card rounded-3xl p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
                
                <div class="relative">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-extrabold text-slate-800">Selamat <span class="text-primary">Datang</span></h2>
                        <p class="text-slate-400 mt-2 text-sm">Silakan masuk ke akun Anda</p>
                    </div>
    
                    <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Alamat Email</label>
                            <div class="relative">
                                <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="email" name="email" placeholder="nama@email.com" required
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                >
                            </div>
                        </div>
    
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kata Sandi</label>
                            <div class="relative">
                                <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="password" name="password" placeholder="••••••••" required
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                >
                            </div>
                        </div>
    
                        <button type="submit" 
                            class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                            Masuk Ke Sistem <i class="bi bi-arrow-right-short text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
            
           
        </div>
    </div>
</body>
</html>