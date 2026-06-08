<x-app-layout>
    <style>
        /* Header */
        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Layout Area */
        .content-area { display: grid; grid-template-columns: 1fr 420px; gap: 24px; }

        /* Panels */
        .panel {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .panel-header {
            padding: 20px 24px;
            border-bottom: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }
        .panel-subtitle { font-size: 12px; color: #94A3B8; margin-top: 2px; }

        /* Forms */
        .form-group { margin-bottom: 20px; padding: 0 24px; }
        .form-group:first-of-type { margin-top: 24px; }
        .form-group:last-of-type { margin-bottom: 24px; }
        
        .label { display: block; font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
        .input {
            width: 100%; height: 44px; padding: 0 16px; border-radius: 10px; border: 1.5px solid #E2E8F0;
            background: #F8FAFC; font-size: 14px; font-weight: 600; color: #0F172A; transition: all 0.2s;
        }
        .input:focus { border-color: #2563EB; background: #fff; outline: none; box-shadow: 0 0 0 4px #EFF6FF; }

        /* Recommendation Filters */
        .rec-filters {
            padding: 14px 24px;
            background: #fff;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-mini {
            flex: 1; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px;
            padding: 0 12px 0 34px; font-size: 13px; font-weight: 600;
            background: #F8FAFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
            outline: none; transition: all 0.2s;
        }
        .search-mini:focus { border-color: #2563EB; background-color: #fff; box-shadow: 0 0 0 3px #EFF6FF; }

        .filter-select-mini {
            width: 130px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px;
            padding: 0 28px 0 10px; font-size: 12px; font-weight: 700; color: #64748B;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 8px center;
            appearance: none; outline: none; cursor: pointer;
        }
        .filter-select-mini:focus { border-color: #2563EB; }

        /* Recommendation List & Scrolling */
        .rec-scroll-area {
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #E2E8F0 transparent;
        }
        .rec-scroll-area::-webkit-scrollbar { width: 6px; }
        .rec-scroll-area::-webkit-scrollbar-track { background: transparent; }
        .rec-scroll-area::-webkit-scrollbar-thumb { background-color: #E2E8F0; border-radius: 20px; }

        .rec-list { padding: 0; }
        .rec-item {
            padding: 16px 24px; border-bottom: 1px solid #F8FAFC;
            display: flex; align-items: center; gap: 14px; transition: background 0.12s;
        }
        .rec-item:hover { background: #FAFBFC; }
        .rec-item:last-child { border-bottom: none; }
        
        .rec-icon {
            width: 40px; height: 40px; border-radius: 10px; background: #EFF6FF;
            display: flex; align-items: center; justify-content: center;
            color: #2563EB; font-size: 18px; flex-shrink: 0;
        }
        .rec-body { flex: 1; min-width: 0; }
        .rec-title { font-size: 13px; font-weight: 700; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .rec-meta { font-size: 11px; color: #94A3B8; font-weight: 600; margin-top: 2px; }

        /* Buttons */
        .btn {
            height: 42px; padding: 0 24px; border-radius: 10px; font-size: 13px; font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; border: none;
        }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-secondary { background: #F1F5F9; color: #334155; }
        .btn-secondary:hover { background: #E2E8F0; }
        
        .btn-add {
            width: 32px; height: 32px; border-radius: 8px; background: #2563EB; color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 14px; border: none; cursor: pointer;
            transition: all 0.1s;
        }
        .btn-add:hover { background: #1D4ED8; transform: scale(1.05); }
        .btn-add:active { transform: scale(0.95); }

        @media (max-width: 1024px) {
            .content-area { grid-template-columns: 1fr; }
        }
    </style>

    <!-- Breadcrumbs Fixed -->
    <x-breadcrumbs :links="[
        ['label' => 'Daftar Tempat Magang', 'url' => route('internships.index')],
        ['label' => 'Tambah Baru']
    ]" />

    <div class="page-header mt-6">
        <h1 class="page-title">Tambah Tempat Magang</h1>
        <p class="page-subtitle">Daftarkan tempat magang baru untuk mulai melakukan analisis MOORA</p>
    </div>

    <div class="content-area">
        <!-- Left: Form -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Informasi Tempat Magang Baru</div>
            </div>
            <form action="{{ route('internships.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="label">Nama Perusahaan / Instansi</label>
                    <input type="text" name="name" class="input" placeholder="Contoh: PT. Teknologi Maju" required value="{{ old('name') }}">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="label">Kategori / Bidang</label>
                    <select name="category_id" class="input" required style="appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' fill=\'none\' stroke=\'%2394A3B8\' stroke-width=\'2\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'m6 9 6 6 6-6\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center;">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="label">Link Website (Opsional)</label>
                    <input type="url" name="website_link" class="input" placeholder="https://perusahaan.com" value="{{ old('website_link') }}">
                    @error('website_link') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="px-6 pb-8 pt-4 flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan Tempat Magang
                    </button>
                    <a href="{{ route('internships.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        <!-- Right: Recommendations with Filtering and Scrolling -->
        <div class="panel" x-data="{ search: '', category: '' }">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Rekomendasi Tempat Magang</div>
                    <div class="panel-subtitle">Data global perusahaan populer</div>
                </div>
            </div>

            <!-- Interactive Filters -->
            <div class="rec-filters">
                <input type="text" x-model="search" placeholder="Cari perusahaan..." class="search-mini">
                <select x-model="category" class="filter-select-mini">
                    <option value="">Semua Bidang</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Scrollable Area -->
            <div class="rec-scroll-area">
                <div class="rec-list">
                    @forelse($globalInternships as $global)
                        @php $catName = $global->category->name ?? 'Umum'; @endphp
                        <div class="rec-item" 
                             x-show="(search === '' || '{{ strtolower($global->name) }}'.includes(search.toLowerCase())) && (category === '' || '{{ $catName }}' === category)">
                            <div class="rec-icon"><i class="ti ti-building"></i></div>
                            <div class="rec-body">
                                <div class="rec-title">{{ $global->name }}</div>
                                <div class="rec-meta">{{ $catName }}</div>
                            </div>
                            <form action="{{ route('internships.bulk') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ids[]" value="{{ $global->id }}">
                                <button type="submit" class="btn-add" title="Tambahkan ke daftar saya">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-300">
                            <i class="ti ti-mood-empty text-4xl mb-2 opacity-20"></i>
                            <p class="text-xs font-bold">Tidak ada rekomendasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($globalInternships->isNotEmpty())
                <div class="p-4 border-t border-slate-50 bg-slate-50/50">
                    <p class="text-[9px] font-bold text-slate-400 text-center leading-relaxed">
                        Menampilkan {{ $globalInternships->count() }} data global. Gunakan fitur cari dan filter untuk mempersempit pilihan.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
