@extends('layouts.app')

@section('title', 'Buat Aspirasi Baru')
@section('page_title', 'Formulir Aspirasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 mb-12">
        <div class="flex items-center gap-5">
            <div class="h-16 w-16 bg-gradient-to-tr from-indigo-500 to-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 rotate-3">
                <i class="bi bi-pencil-square text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Suarakan Aspirasimu</h3>
                <p class="text-sm text-slate-500 font-medium">Langkah kecilmu membawa perubahan besar bagi sekolah.</p>
            </div>
        </div>
        
        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-wider">Formulir Terenkripsi</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-8 border-rose-500 rounded-3xl shadow-sm animate-shake">
            <div class="flex items-center gap-3 text-rose-700 font-bold mb-3">
                <i class="bi bi-shield-exclamation text-xl"></i>
                <span class="text-sm uppercase tracking-wider">Perbaiki Kesalahan Berikut:</span>
            </div>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 list-none text-xs text-rose-600 font-medium space-y-1">
                @foreach ($errors->all() as $err)
                    <li class="flex items-center gap-2">
                        <span class="h-1 w-1 bg-rose-400 rounded-full"></span> {{ $err }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="md:col-span-7 lg:col-span-8 group">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 group-focus-within:text-primary transition-colors">Judul Aspirasi</label>
                <div class="relative">
                    <input type="text" name="title" 
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem] focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5 transition-all duration-300 outline-none font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium"
                           placeholder="Contoh: Fasilitas Kursi di Perpustakaan Rusak" required>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors">
                        <i class="bi bi-type"></i>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 lg:col-span-4 group">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 group-focus-within:text-primary transition-colors">Kategori Sektor</label>
                <div class="relative">
                    <select name="category_id" 
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem] focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5 transition-all outline-none font-bold text-slate-600 appearance-none cursor-pointer" required>
                        <option value="" disabled selected>Pilih Bidang...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                        <i class="bi bi-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 group-focus-within:text-primary transition-colors">Deskripsi Kejadian</label>
            <textarea name="description" rows="6" 
                      class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-[2rem] focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5 transition-all duration-300 outline-none font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium resize-none"
                      placeholder="masukan deskripsi di sini dengan lengkap dan detail" required></textarea>
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 group-focus-within:text-primary transition-colors">
                Lokasi Kejadian
            </label>
            <div class="relative">
                <input type="text"
                       name="location"
                       value="{{ old('location') }}"
                       class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                              focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                              transition-all duration-300 outline-none font-bold text-slate-700
                              placeholder:text-slate-300 placeholder:font-medium"
                       placeholder="Contoh: Perpustakaan Lantai 3 / Ruang BK / Kelas X RPL 1"
                       required>
        
                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
        </div>
        

        <div class="relative group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 group-hover:text-primary transition-colors">Berkas Pendukung (Bukti Foto/Dokumen)</label>
            <div id="drop-area" class="relative overflow-hidden p-10 border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50/50 hover:bg-white hover:border-primary transition-all duration-500 text-center cursor-pointer">
                <input id="file-upload" name="attachment" type="file" class="hidden" accept=".png,.jpg,.jpeg,.pdf">
                
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="h-16 w-16 rounded-3xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-300 group-hover:text-primary group-hover:scale-110 transition-all duration-500">
                        <i class="bi bi-cloud-upload text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-700">Tarik berkas ke sini atau <span class="text-primary hover:underline">Klik Browser</span></p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Maksimal Ukuran 2MB (JPG, PNG, PDF)</p>
                    </div>
                    <div id="file-name-display" class="hidden px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold border border-emerald-100 animate-bounce">
                        <i class="bi bi-check-all mr-1"></i> <span id="file-name-text"></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-100">
            <button type="reset" class="order-2 sm:order-1 flex items-center gap-2 text-[11px] font-black text-slate-400 hover:text-rose-500 transition-all uppercase tracking-[2px]">
                <i class="bi bi-trash3-fill"></i> Hapus Draft
            </button>
            
            <button type="submit" 
                    class="order-1 sm:order-2 w-full sm:w-auto px-12 py-5 bg-slate-900 text-white font-black rounded-[1.5rem] shadow-2xl shadow-slate-200 hover:bg-primary hover:shadow-indigo-300 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-4 group">
                <span>SUBMIT ASPIRASI</span>
                <i class="bi bi-arrow-right-short text-2xl group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>

<script>
    const fileInput = document.getElementById('file-upload');
    const dropArea = document.getElementById('drop-area');
    const nameDisplay = document.getElementById('file-name-display');
    const nameText = document.getElementById('file-name-text');

    dropArea.addEventListener('click', () => fileInput.click());

    fileInput.onchange = function() {
        const fileName = this.files[0]?.name;
        if (fileName) {
            nameText.innerText = fileName;
            nameDisplay.classList.remove('hidden');
            dropArea.classList.add('border-emerald-400', 'bg-emerald-50/20');
        }
    };

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('border-primary', 'bg-indigo-50/50'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('border-primary', 'bg-indigo-50/50'), false);
    });

    dropArea.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        fileInput.dispatchEvent(new Event('change'));
    });
</script>
@endsection