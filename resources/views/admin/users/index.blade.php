<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Mahasiswa']]" />
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Data Mahasiswa</h1>
                <p class="text-[14px] text-[#64748B] font-medium">Kelola akun mahasiswa yang terdaftar dalam sistem.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 h-[42px] bg-[#2563EB] text-white text-[13px] font-bold rounded-[10px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/10">
                <i class="ti ti-plus text-base"></i>
                Tambah Mahasiswa
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
                <h3 class="text-[15px] font-bold text-[#0F172A]">Daftar Mahasiswa</h3>
                
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative w-full md:w-[260px]">
                        <input type="text" name="search" value="{{ request('search') }}" class="search-box" placeholder="Cari nama atau email...">
                    </div>
                    <button type="submit" class="h-10 px-5 flex items-center justify-center bg-[#2563EB] text-white text-[12px] font-bold rounded-xl hover:bg-[#1D4ED8] transition-all">
                        Cari
                    </button>
                </form>
            </div>

            @if($users->isEmpty())
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-users text-3xl text-[#94A3B8]"></i>
                    </div>
                    <p class="text-[#64748B] font-bold">Belum ada data mahasiswa.</p>
                    <p class="text-[12px] text-[#94A3B8] mt-1">Gunakan tombol tambah untuk membuat akun mahasiswa baru atau coba kata kunci lain.</p>
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC]">
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[80px]">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Email</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Terdaftar</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[200px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @foreach($users as $u)
                                <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#64748B]">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-[#2563EB] flex items-center justify-center text-white text-[13px] font-bold overflow-hidden flex-shrink-0">
                                                @if($u->photo)
                                                    <img src="{{ asset('storage/'.$u->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($u->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <span class="text-[14px] font-bold text-[#0F172A]">{{ $u->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] text-[#64748B] font-medium">{{ $u->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-[12px] text-[#94A3B8] font-bold">
                                        {{ $u->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $u) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-[8px] hover:bg-[#E2E8F0] transition-all">
                                                <i class="ti ti-edit text-sm"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus mahasiswa ini?')">
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
                    @foreach($users as $u)
                        <div class="bg-white border border-[#E2E8F0] rounded-xl p-4 shadow-sm shadow-slate-100">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-[#2563EB] flex items-center justify-center text-white text-[14px] font-bold overflow-hidden flex-shrink-0">
                                    @if($u->photo)
                                        <img src="{{ asset('storage/'.$u->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($u->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-[14px] font-bold text-[#0F172A] leading-tight">{{ $u->name }}</h4>
                                    <p class="text-[11px] text-[#64748B] font-medium mt-0.5">{{ $u->email }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-[#F1F5F9]">
                                <a href="{{ route('admin.users.edit', $u) }}" class="flex justify-center items-center gap-1.5 py-2 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold rounded-lg hover:bg-[#E2E8F0]">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus mahasiswa ini?')" class="w-full">
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

                {{ $users->appends(request()->query())->links('vendor.pagination.admin') }}
            @endif
        </div>
    </div>
</x-admin-layout>
