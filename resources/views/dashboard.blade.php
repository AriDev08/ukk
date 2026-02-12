@extends('layouts.app')

@section('title', 'Histori Aspirasi')
@section('page_title', 'Histori Pengajuan')

@section('content')
<div x-data="aspirasiDashboard()" class="space-y-8" x-init="init()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800">Lacak Aspirasi Anda</h3>
            <p class="text-sm text-slate-500">Pantau status, tanggapan admin, dan kelola lampiran secara mudah.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('aspirasi.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-primary to-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg hover:scale-[1.02]">
                <i class="bi bi-plus-lg"></i>
                <span>Buat Aspirasi Baru</span>
            </a>

            <div class="hidden sm:flex items-center gap-2">
                <button @click="exportCsv" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 shadow">Export CSV</button>
                <a href="{{ route('aspirasi.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 shadow">Export (Server)</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 rounded-2xl shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill text-xl"></i>
            <div class="ml-3 text-sm font-bold">
                {{ session('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 bg-emerald-50 text-emerald-500 rounded-lg p-1.5 hover:bg-emerald-100 inline-flex items-center justify-center h-8 w-8" @click="$el.parentElement.remove()" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <!-- Controls: Search, Filters, View Toggle -->
    <form method="GET" action="{{ route('aspirasi.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
        <div class="col-span-2 flex gap-3">
            <input name="q" value="{{ request('q') }}" type="search" placeholder="Cari judul, deskripsi atau admin..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm focus:outline-none" />

            <select name="status" class="px-4 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="process" {{ request('status')=='process' ? 'selected' : '' }}>Process</option>
                <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>Done</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <select name="category" class="px-4 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 rounded-xl border border-slate-200 bg-white shadow-sm" />
            <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 rounded-xl border border-slate-200 bg-white shadow-sm" />
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-2xl font-bold">Filter</button>
        </div>
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white shadow-md flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Total Aspirasi</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $items->total() }}</h3>
            </div>
            <div class="text-3xl text-primary opacity-80">
                <i class="bi bi-archive"></i>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white shadow-md flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Dalam Proses</p>
                <h3 class="text-2xl font-extrabold text-indigo-600">{{ $stats['process'] ?? 0 }}</h3>
            </div>
            <div class="text-3xl text-indigo-300 opacity-90">
                <i class="bi bi-arrow-repeat"></i>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white shadow-md flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Selesai</p>
                <h3 class="text-2xl font-extrabold text-emerald-600">{{ $stats['done'] ?? 0 }}</h3>
            </div>
            <div class="text-3xl text-emerald-300 opacity-90">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white shadow-md flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Belum Ditanggapi</p>
                <h3 class="text-2xl font-extrabold text-amber-600">{{ $stats['pending'] ?? 0 }}</h3>
            </div>
            <div class="text-3xl text-amber-300 opacity-90">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>

    <!-- Table / Card container -->
    <div class="overflow-hidden border border-slate-100 rounded-[2rem] bg-slate-50/50 p-2">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" @click="toggleAll($event)" class="w-4 h-4" />
                    <span class="text-xs text-slate-500">Pilih Semua</span>
                </label>

                <div x-show="selected.length" class="inline-flex items-center gap-2">
                    <button @click="bulkAction('export')" class="px-3 py-2 bg-white border rounded-xl text-xs">Export Selected</button>
                    <button @click="bulkAction('mark_read')" class="px-3 py-2 bg-white border rounded-xl text-xs">Tandai Dibaca</button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click="view='table'" :class="{'bg-white': view=='table'}" class="px-3 py-2 rounded-xl text-xs border">Table</button>
                <button @click="view='card'" :class="{'bg-white': view=='card'}" class="px-3 py-2 rounded-xl text-xs border">Card</button>
            </div>
        </div>

        <!-- Table view -->
        <div x-show="view=='table'" class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-3 px-2">
                <thead>
                    <tr class="text-left text-slate-400 uppercase text-[10px] tracking-[2px] font-bold">
                        <th class="px-6 py-4">&nbsp;</th>
                        <th class="px-6 py-4">Info Dasar</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Feedback Terakhir</th>
                        <th class="px-6 py-4 text-right">Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $row)
                    <tr @click="openDetail({{ $row->id }})" class="bg-white hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md rounded-2xl group cursor-pointer">
                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100">
                            <input type="checkbox" value="{{ $row->id }}" @click.stop="toggleSelected({{ $row->id }})" :checked="selected.includes({{ $row->id }})" class="w-4 h-4" />
                        </td>

                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400 mb-1">{{ $row->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-sm font-bold text-slate-800 line-clamp-1 uppercase tracking-tight">{{ $row->title }}</span>
                                <span class="text-[11px] text-slate-400 italic line-clamp-1 mt-0.5">{{ Str::limit($row->description, 60) }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">{{ $row->category->name }}</span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'process' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                                    'done'    => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'rejected'=> 'bg-rose-100 text-rose-600 border-rose-200'
                                ];
                                $currentClass = $statusClasses[$row->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl text-[10px] font-black border {{ $currentClass }} min-w-[100px] shadow-sm uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 animate-pulse"></span>
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            @php $lastFeedback = $row->histories->last(); @endphp
                            @if($lastFeedback)
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="bi bi-chat-left-text text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[11px] font-bold text-slate-700">{{ $lastFeedback->admin->name ?? 'Admin' }}</span>
                                        <span class="text-[10px] text-slate-400 line-clamp-1">{{ Str::limit($lastFeedback->note, 60) }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-[11px] font-medium text-slate-300 italic">Menunggu respon...</span>
                            @endif
                        </td>

                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-transparent group-hover:border-slate-100 text-right">
                            @if($row->attachment_path)
                                <a href="{{ asset('storage/'.$row->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                    File
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase">No File</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="bi bi-inbox text-slate-300 text-3xl"></i>
                                </div>
                                <h4 class="text-slate-800 font-bold">Belum Ada Aspirasi</h4>
                                <p class="text-sm text-slate-400">Suara Anda sangat berarti bagi kami. Mulailah menulis aspirasi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card view for mobile / alternate -->
        <div x-show="view=='card'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($items as $row)
            <div class="bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition cursor-pointer" @click="openDetail({{ $row->id }})">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <span class="text-xs font-bold text-slate-400">{{ $row->created_at->translatedFormat('d M Y') }}</span>
                        <h4 class="text-lg font-extrabold text-slate-800 mt-1 line-clamp-1">{{ $row->title }}</h4>
                        <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ Str::limit($row->description, 120) }}</p>
                    </div>

                    <div class="text-right">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">{{ $row->category->name }}</div>
                        <div class="mt-3">
                            @php $cls = $row->status == 'done' ? 'text-emerald-600' : ($row->status=='process' ? 'text-indigo-600' : ($row->status=='rejected' ? 'text-rose-600' : 'text-amber-600')) @endphp
                            <div class="text-xs font-bold {{ $cls }} uppercase">{{ $row->status }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <!-- handled above -->
            @endforelse
        </div>

    </div>

    <!-- Footer: pagination & summary -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6 px-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Showing <span class="text-primary">{{ $items->firstItem() ?? 0 }}</span> - <span class="text-primary">{{ $items->lastItem() ?? 0 }}</span> of {{ $items->total() }} entries</p>
        <div class="custom-pagination">
            {{ $items->withQueryString()->links() }}
        </div>
    </div>

    <!-- Detail modal (Alpine) -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="closeModal()"></div>
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 z-10">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800" x-text="modalItem.title"></h3>
                    <p class="text-xs text-slate-400" x-text="modalItem.date"></p>
                </div>
                <button class="p-2" @click="closeModal()"><i class="bi bi-x-lg text-lg"></i></button>
            </div>

            <div class="mt-4">
                <p class="text-sm text-slate-700" x-text="modalItem.description"></p>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div>
                    <template x-if="modalItem.attachment">
                        <a :href="modalItem.attachment" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600">Download Lampiran</a>
                    </template>
                </div>
                <div>
                    <a :href="modalItem.showRoute" class="px-4 py-2 bg-primary text-white rounded-2xl font-bold">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .custom-pagination nav svg { width: 20px; display: inline; }
    .custom-pagination nav div:first-child { display: none; } /* Hide mobile nav from default laravel */
    .custom-pagination nav div:last-child span, .custom-pagination nav div:last-child a { border-radius: 12px !important; margin: 0 2px; font-weight: 700; font-size: 12px; }
</style>

<!-- Alpine + helpers -->
<script>
function aspirasiDashboard(){
    return {
        view: 'table',
        selected: [],
        modalOpen: false,
        modalItem: {},
        init(){
            // remember preferred view in query or localStorage
            const v = new URLSearchParams(window.location.search).get('view');
            if(v) this.view = v;
        },
        toggleAll(e){
            const checked = e.target.checked;
            this.selected = [];
            if(checked){
                // collect visible row ids from DOM (progressive enhancement)
                document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb=>{
                    if(cb.value) this.selected.push(Number(cb.value));
                    cb.checked = true;
                });
            }else{
                document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb=> cb.checked = false);
            }
        },
        toggleSelected(id){
            const i = this.selected.indexOf(id);
            if(i === -1) this.selected.push(id); else this.selected.splice(i,1);
        },
        bulkAction(action){
            if(!this.selected.length) return alert('Pilih minimal 1 item');
            // For demo, we just export selected ids to CSV or open route. Replace with server POST for real action.
            if(action === 'export'){
                const rows = this.selected.map(id=> [id]);
                const csv = [['id'], ...rows].map(r=> r.join(',')).join('\n');
                const blob = new Blob([csv], { type: 'text/csv' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a'); a.href = url; a.download = 'aspirasi_selected.csv'; a.click(); URL.revokeObjectURL(url);
            }
            if(action === 'mark_read'){
                alert('Bulk mark as read: ' + this.selected.join(','));
                // call your API here
            }
        },
        openDetail(id){
            // fetch detail using AJAX route (create route: aspirasi.show.json)
            fetch("{{ url('/aspirasi') }}/" + id + "/json")
                .then(r=> r.json())
                .then(data => {
                    this.modalItem = {
                        title: data.title,
                        date: data.created_at_formatted || data.created_at,
                        description: data.description,
                        attachment: data.attachment_url || null,
                        showRoute: "{{ url('/aspirasi') }}/"+id
                    };
                    this.modalOpen = true;
                })
                .catch(()=>{
                    // fallback: open detail page
                    window.location.href = "{{ url('/aspirasi') }}/" + id;
                });
        },
        closeModal(){ this.modalOpen = false; this.modalItem = {} },
        exportCsv(){
            // export visible rows to CSV (simple client-side)
            const headers = ['id','title','date','status','category'];
            const rows = [];
            document.querySelectorAll('tbody tr').forEach(tr=>{
                const idInput = tr.querySelector('input[type="checkbox"]');
                if(!idInput) return;
                const id = idInput.value || '';
                const title = tr.querySelector('td:nth-child(2) .line-clamp-1')?.innerText || tr.querySelector('td:nth-child(2)')?.innerText.trim();
                const date = tr.querySelector('td:nth-child(2) .text-xs')?.innerText || '';
                const status = tr.querySelector('td:nth-child(4)')?.innerText.trim() || '';
                const category = tr.querySelector('td:nth-child(3)')?.innerText.trim() || '';
                rows.push([id, '"'+title.replace(/"/g,'""')+'"', date, status, category]);
            });
            const csv = [headers.join(','), ...rows.map(r=> r.join(','))].join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href = url; a.download = 'aspirasi_export.csv'; a.click(); URL.revokeObjectURL(url);
        }
    }
}
</script>

@endsection
