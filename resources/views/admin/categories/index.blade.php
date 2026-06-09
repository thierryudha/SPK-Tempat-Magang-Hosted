<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Bidang']]" />
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Daftar Bidang</h1>
                <p class="text-[14px] text-[#64748B] font-medium">Kelola kategori atau bidang industri untuk tempat magang.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 h-[42px] bg-[#2563EB] text-white text-[13px] font-bold rounded-[10px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/10">
                <i class="ti ti-plus text-base"></i>
                Tambah Bidang
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
                <h3 class="text-[15px] font-bold text-[#0F172A]">Data Bidang</h3>

                <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center gap-3">
                    <div class="relative w-full md:w-[250px]">
                        <input type="text" name="search" value="{{ request('search') }}" class="search-box" placeholder="Cari nama bidang...">
                    </div>
                    <button type="submit" class="h-10 px-5 flex items-center justify-center bg-[#2563EB] text-white text-[12px] font-bold rounded-xl hover:bg-[#1D4ED8] transition-all">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.categories.index') }}" class="h-10 px-4 flex items-center justify-center bg-[#F1F5F9] text-[#64748B] text-[12px] font-bold rounded-xl hover:bg-[#E2E8F0] transition-all">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if($categories->isEmpty())
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-folders text-3xl text-[#94A3B8]"></i>
                    </div>
                    <p class="text-[#64748B] font-bold">Belum ada data bidang.</p>
                    <p class="text-[12px] text-[#94A3B8] mt-1">Tambahkan bidang baru untuk mengkategorikan tempat magang.</p>
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC]">
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[80px]">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Nama Bidang / Industri</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[200px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @foreach($categories as $cat)
                                <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#64748B]">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#0F172A]">{{ $cat->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $cat) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-[8px] hover:bg-[#E2E8F0] transition-all">
                                                <i class="ti ti-edit text-sm"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus bidang ini?')">
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
                    @foreach($categories as $cat)
                        <div class="bg-white border border-[#E2E8F0] rounded-xl p-4 shadow-sm shadow-slate-100">
                            <h4 class="text-[14px] font-bold text-[#0F172A] mb-4">{{ $cat->name }}</h4>
                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-[#F1F5F9]">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="flex justify-center items-center gap-1.5 py-2 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold rounded-lg hover:bg-[#E2E8F0]">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus bidang ini?')" class="w-full">
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
            @endif

            {{ $categories->appends(request()->query())->links('vendor.pagination.admin') }}
        </div>
    </div>
</x-admin-layout>
