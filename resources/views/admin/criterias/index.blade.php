<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Kriteria']]" />
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Manajemen Kriteria</h1>
                <p class="text-[14px] text-[#64748B] font-medium">Atur parameter penilaian untuk perhitungan metode MOORA.</p>
            </div>
            <a href="{{ route('admin.criterias.create') }}" class="inline-flex items-center gap-2 px-5 h-[42px] bg-[#2563EB] text-white text-[13px] font-bold rounded-[10px] hover:bg-[#1D4ED8] transition-all shadow-sm shadow-blue-500/10">
                <i class="ti ti-plus text-base"></i>
                Tambah Kriteria
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold rounded-xl flex items-center gap-3">
                <i class="ti ti-circle-check text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50">
            <div class="px-6 py-5 border-b border-[#F1F5F9] flex items-center justify-between">
                <h3 class="text-[15px] font-bold text-[#0F172A]">Data Kriteria</h3>
            </div>

            @if($criterias->isEmpty())
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-list-details text-3xl text-[#94A3B8]"></i>
                    </div>
                    <p class="text-[#64748B] font-bold">Belum ada data kriteria.</p>
                    <p class="text-[12px] text-[#94A3B8] mt-1">Tambahkan kriteria baru untuk memulai penilaian.</p>
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC]">
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[100px]">Kode</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Nama Kriteria Penilaian</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[150px]">Tipe</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[200px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @foreach($criterias as $c)
                                <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-[#F1F5F9] text-[#475569] text-[10px] font-bold rounded-md uppercase tracking-wider">{{ $c->code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[14px] font-bold text-[#0F172A]">{{ $c->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($c->type == 'benefit')
                                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-md uppercase tracking-wider border border-emerald-100">
                                                <i class="ti ti-arrow-up-right mr-1"></i> Benefit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 bg-rose-50 text-rose-600 text-[10px] font-bold rounded-md uppercase tracking-wider border border-rose-100">
                                                <i class="ti ti-arrow-down-right mr-1"></i> Cost
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.criterias.edit', $c) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[12px] font-bold rounded-[8px] hover:bg-[#E2E8F0] transition-all">
                                                <i class="ti ti-edit text-sm"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.criterias.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus kriteria ini?')">
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
                    @foreach($criterias as $c)
                        <div class="bg-white border border-[#E2E8F0] rounded-xl p-4 shadow-sm shadow-slate-100">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="inline-flex items-center px-2 py-0.5 bg-[#F1F5F9] text-[#475569] text-[10px] font-bold rounded-md uppercase tracking-wider mb-1">{{ $c->code }}</span>
                                    <h4 class="text-[14px] font-bold text-[#0F172A]">{{ $c->name }}</h4>
                                </div>
                                @if($c->type == 'benefit')
                                    <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded-md uppercase tracking-wider border border-emerald-100">Benefit</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-bold rounded-md uppercase tracking-wider border border-rose-100">Cost</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-[#F1F5F9]">
                                <a href="{{ route('admin.criterias.edit', $c) }}" class="flex justify-center items-center gap-1.5 py-2 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold rounded-lg hover:bg-[#E2E8F0]">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.criterias.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus kriteria ini?')" class="w-full">
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
        </div>
    </div>
</x-admin-layout>
