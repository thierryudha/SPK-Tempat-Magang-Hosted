<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Kontribusi Mahasiswa']]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Kontribusi Mahasiswa</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Daftar perusahaan yang ditambahkan secara pribadi oleh mahasiswa.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold rounded-xl flex items-center gap-3 shadow-sm shadow-emerald-500/5">
                <i class="ti ti-circle-check text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 text-sm font-bold rounded-xl flex items-center gap-3 shadow-sm shadow-rose-500/5">
                <i class="ti ti-alert-circle text-lg"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50">
            <div class="px-6 py-5 border-b border-[#F1F5F9] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="text-[15px] font-bold text-[#0F172A]">Daftar Perusahaan Mahasiswa</h3>
                
                <form action="{{ route('admin.user-internships.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
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

                    @if(request('search') || request('category_id'))
                        <a href="{{ route('admin.user-internships.index') }}" class="h-10 px-4 flex items-center justify-center bg-[#F1F5F9] text-[#64748B] text-[12px] font-bold rounded-xl hover:bg-[#E2E8F0] transition-all">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-[#F8FAFC]">
                            <th class="px-6 py-4 text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[80px]">No</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Penginput</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Perusahaan</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Bidang</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Status</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[300px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($internships as $i)
                            <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-[14px] font-bold text-[#64748B]">{{ ($internships->currentPage() - 1) * $internships->perPage() + $loop->iteration }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-[#F1F5F9] flex items-center justify-center text-[#64748B] text-[13px] font-bold overflow-hidden flex-shrink-0">
                                            {{ substr($i->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[14px] font-bold text-[#0F172A]">{{ $i->user->name }}</span>
                                            <span class="text-[11px] text-[#94A3B8] font-bold uppercase tracking-tight">Mahasiswa</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-[14px] font-bold text-[#0F172A] capitalize">{{ $i->name }}</span>
                                        @if($i->website_link)
                                            <a href="{{ $i->website_link }}" target="_blank" class="text-[11px] text-[#2563EB] font-bold hover:underline inline-flex items-center gap-1 mt-0.5">
                                                <i class="ti ti-world text-[13px]"></i>
                                                Kunjungi Website
                                            </a>
                                        @else
                                            <span class="text-[11px] text-[#94A3B8] font-medium italic mt-0.5">Tidak ada link website</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-100">
                                        {{ $i->category->name ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if(in_array(strtolower($i->name), $globalNames))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-extrabold uppercase border border-emerald-100">
                                            <i class="ti ti-check mr-1"></i> Sudah Ada Global
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-50 text-slate-500 text-[10px] font-extrabold uppercase border border-slate-200">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.internships.edit', $i) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-[8px] hover:bg-[#E2E8F0] transition-all">
                                            <i class="ti ti-edit text-sm"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.user-internships.promote', $i) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#2563EB] text-white text-[12px] font-bold rounded-[8px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/10">
                                                <i class="ti ti-arrow-up-circle text-sm"></i>
                                                Promote to Global
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center">
                                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="ti ti-building-community text-3xl text-[#94A3B8]"></i>
                                    </div>
                                    <p class="text-[#64748B] font-bold">Belum ada kontribusi data dari mahasiswa.</p>
                                    <p class="text-[12px] text-[#94A3B8] mt-1">Data perusahaan yang diinput mahasiswa akan muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-[#F8FAFC]">
                @forelse($internships as $i)
                    <div class="bg-white border border-[#E2E8F0] rounded-xl p-5 shadow-sm shadow-slate-200/50">
                        <div class="flex items-center gap-3 mb-4 bg-[#F8FAFC] -mx-5 -mt-5 p-4 border-b border-[#F1F5F9] rounded-t-xl">
                            <div class="w-10 h-10 rounded-full bg-white border border-[#E2E8F0] flex items-center justify-center text-[#64748B] text-[14px] font-bold overflow-hidden flex-shrink-0 shadow-sm">
                                {{ substr($i->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-[#0F172A] leading-tight">{{ $i->user->name }}</p>
                                <p class="text-[11px] text-[#94A3B8] font-bold uppercase mt-0.5">Mahasiswa</p>
                            </div>
                            <div>
                                @if(in_array(strtolower($i->name), $globalNames))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[9px] font-extrabold uppercase border border-emerald-100">
                                        <i class="ti ti-check mr-1"></i> Global
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-50 text-slate-500 text-[9px] font-extrabold uppercase border border-slate-200">
                                        Belum
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="text-[16px] font-extrabold text-[#0F172A] leading-tight capitalize">{{ $i->name }}</h4>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-100">
                                        {{ $i->category->name ?? 'Umum' }}
                                    </span>
                                    @if($i->website_link)
                                        <a href="{{ $i->website_link }}" target="_blank" class="w-8 h-8 rounded-lg bg-[#F1F5F9] text-[#475569] flex items-center justify-center hover:bg-[#E2E8F0] transition-all">
                                            <i class="ti ti-world"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-4 border-t border-[#F1F5F9]">
                                <a href="{{ route('admin.internships.edit', $i) }}" class="flex justify-center items-center gap-1.5 py-2.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-lg hover:bg-[#E2E8F0]">
                                    <i class="ti ti-edit text-base"></i> Edit
                                </a>
                                <form action="{{ route('admin.user-internships.promote', $i) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center gap-1.5 py-2.5 bg-[#2563EB] text-white text-[12px] font-bold rounded-lg hover:bg-[#1D4ED8] shadow-sm shadow-blue-500/10">
                                        <i class="ti ti-arrow-up-circle text-base"></i> Promote
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-white border border-[#E2E8F0] rounded-xl p-6">
                        <i class="ti ti-building-community text-4xl text-[#94A3B8] mb-3 block"></i>
                        <p class="text-[#64748B] font-bold text-sm">Belum ada kontribusi mahasiswa.</p>
                    </div>
                @endforelse
            </div>

            {{ $internships->appends(request()->query())->links('vendor.pagination.admin') }}
        </div>
    </div>
</x-admin-layout>
