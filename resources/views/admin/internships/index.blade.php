<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Perusahaan']]" />
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Direktori Perusahaan</h1>
                <p class="text-[14px] text-[#64748B] font-medium">Kelola data perusahaan magang untuk referensi mahasiswa.</p>
            </div>
            <a href="{{ route('admin.internships.create') }}" class="inline-flex items-center gap-2 px-5 h-[42px] bg-[#2563EB] text-white text-[13px] font-bold rounded-[10px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/10">
                <i class="ti ti-plus text-base"></i>
                Tambah Perusahaan
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold rounded-xl flex items-center gap-3">
                <i class="ti ti-circle-check text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50">
            <div class="px-6 py-5 border-b border-[#F1F5F9] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="text-[15px] font-bold text-[#0F172A]">Data Perusahaan</h3>
                
                <form action="{{ route('admin.internships.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="relative w-full md:w-[250px]">
                        <input type="text" name="search" value="{{ request('search') }}" class="search-box" placeholder="Cari nama perusahaan...">
                    </div>
                    
                    <button type="submit" class="h-10 px-5 flex items-center justify-center bg-[#2563EB] text-white text-[12px] font-bold rounded-xl hover:bg-[#1D4ED8] transition-all">
                        Cari
                    </button>

                    <div class="relative w-full md:w-[180px]">
                        <select name="category_id" class="search-box appearance-none" onchange="this.form.submit()">
                            <option value="">Semua Bidang</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#94A3B8]">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </form>
            </div>

            @if($internships->isEmpty())
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-building text-3xl text-[#94A3B8]"></i>
                    </div>
                    <p class="text-[#64748B] font-bold">Belum ada data perusahaan.</p>
                    @if(request('search') || request('category_id'))
                        <p class="text-[12px] text-[#94A3B8] mt-1">Gunakan kata kunci atau filter lain.</p>
                    @else
                        <p class="text-[12px] text-[#94A3B8] mt-1">Tambahkan perusahaan baru untuk mulai mengisi database.</p>
                    @endif
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC]">
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[80px]">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Nama Perusahaan</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Bidang / Sektor</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Website</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[200px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @foreach($internships as $i)
                                <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#64748B]">{{ ($internships->currentPage() - 1) * $internships->perPage() + $loop->iteration }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#0F172A]">{{ $i->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                            {{ $i->category->name ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($i->website_link)
                                            <a href="{{ $i->website_link }}" target="_blank" class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#2563EB] hover:underline">
                                                <i class="ti ti-external-link text-sm"></i>
                                                Visit Site
                                            </a>
                                        @else
                                            <span class="text-[13px] text-[#94A3B8] italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.internships.edit', $i) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-[8px] hover:bg-[#E2E8F0] transition-all">
                                                <i class="ti ti-edit text-sm"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.internships.destroy', $i) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#FEF2F2] text-[#DC2626] text-[12px] font-bold rounded-[8px] hover:bg-[#FEE2E2] transition-all">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden grid grid-cols-1 gap-4 p-4">
                    @foreach($internships as $i)
                        <div class="bg-white border border-[#E2E8F0] rounded-xl p-4 shadow-sm shadow-slate-100">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-[14px] font-bold text-[#0F172A]">{{ $i->name }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    {{ $i->category->name ?? 'Umum' }}
                                </span>
                            </div>
                            
                            @if($i->website_link)
                                <a href="{{ $i->website_link }}" target="_blank" class="inline-flex items-center gap-1 text-[12px] font-semibold text-[#2563EB] mb-4">
                                    <i class="ti ti-external-link text-xs"></i>
                                    Visit Website
                                </a>
                            @endif

                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-[#F1F5F9]">
                                <a href="{{ route('admin.internships.edit', $i) }}" class="flex justify-center items-center gap-1.5 py-2 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold rounded-lg hover:bg-[#E2E8F0]">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.internships.destroy', $i) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini?')" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full flex justify-center items-center gap-1.5 py-2 bg-[#FEF2F2] text-[#DC2626] text-[11px] font-bold rounded-lg hover:bg-[#FEE2E2]">
                                        <i class="ti ti-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $internships->appends(request()->query())->links('vendor.pagination.admin') }}
            @endif
        </div>
    </div>
</x-admin-layout>
