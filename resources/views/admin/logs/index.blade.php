<x-admin-layout>
    <div class="mt-4">
        <x-breadcrumbs :links="[['label' => 'Log Aktivitas']]" />
        
        <div class="mb-8">
            <h1 class="text-[26px] font-[800] text-[#0F172A] tracking-tight leading-none mb-2">Log Aktivitas Sistem</h1>
            <p class="text-[14px] text-[#64748B] font-medium">Pantau seluruh perubahan data dan tindakan administratif yang dilakukan tim.</p>
        </div>

        <div class="bg-white border-[0.5px] border-[#E2E8F0] rounded-[16px] overflow-hidden shadow-sm shadow-slate-200/50">
            <div class="px-6 py-5 border-b border-[#F1F5F9] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="text-[15px] font-bold text-[#0F172A]">Rekaman Aktivitas</h3>
                
                <form action="{{ route('admin.logs.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="relative w-full md:w-[220px]">
                        <input type="text" name="search" value="{{ request('search') }}" class="search-box" placeholder="Cari pelaku atau ket...">
                    </div>

                    <button type="submit" class="h-10 px-5 flex items-center justify-center bg-[#2563EB] text-white text-[12px] font-bold rounded-xl hover:bg-[#1D4ED8] transition-all">
                        Cari
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC]">
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[60px]">No</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[150px]">Waktu</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Pelaku</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Role</th>
                            <th class="px-6 py-4 text-center text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Tindakan</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9]">Keterangan</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold text-[#94A3B8] uppercase tracking-wider border-b border-[#F1F5F9] w-[100px]">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($logs as $log)
                            <tr class="hover:bg-[#F8FAFC]/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-[13px] font-bold text-[#64748B]">{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-[13px] font-bold text-[#0F172A]">{{ $log->created_at->format('d M Y') }}</span>
                                        <span class="text-[11px] text-[#94A3B8] font-medium tracking-tight">{{ $log->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#2563EB]/10 flex items-center justify-center text-[#2563EB] text-[11px] font-bold overflow-hidden flex-shrink-0">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-[13px] font-bold text-[#0F172A]">{{ $log->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[12px] font-bold {{ $log->user->role === 'admin' ? 'text-rose-600' : 'text-blue-600' }} capitalize">
                                        {{ $log->user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border
                                        @if($log->action == 'Created') bg-emerald-50 text-emerald-600 border-emerald-100
                                        @elseif($log->action == 'Updated') bg-blue-50 text-blue-600 border-blue-100
                                        @elseif($log->action == 'Deleted') bg-rose-50 text-rose-600 border-rose-100
                                        @else bg-slate-50 text-slate-600 border-slate-100
                                        @endif">
                                        @if($log->action == 'Created') <i class="ti ti-plus mr-1 text-[10px]"></i>
                                        @elseif($log->action == 'Updated') <i class="ti ti-edit mr-1 text-[10px]"></i>
                                        @elseif($log->action == 'Deleted') <i class="ti ti-trash mr-1 text-[10px]"></i>
                                        @endif
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-[13px] text-[#64748B] font-medium leading-relaxed max-w-[300px] line-clamp-2" title="{{ $log->description }}">{{ $log->description }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold rounded-lg hover:bg-[#E2E8F0] transition-all">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-20 text-center">
                                    <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="ti ti-history text-3xl text-[#94A3B8]"></i>
                                    </div>
                                    <p class="text-[#64748B] font-bold">Belum ada rekaman aktivitas.</p>
                                    <p class="text-[12px] text-[#94A3B8] mt-1">Seluruh tindakan administratif akan muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $logs->appends(request()->query())->links('vendor.pagination.admin') }}
        </div>
    </div>
</x-admin-layout>
