<x-admin-layout>
    <div class="max-w-7xl mx-auto">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Log Aktivitas Sistem</h1>
            <p class="text-slate-500 text-sm mt-1 font-bold uppercase tracking-widest text-[10px]">Pantau seluruh perubahan data dan tindakan administratif yang dilakukan tim.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-900 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Waktu</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Administrator</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Tindakan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Modul</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-5 text-center">
                                <p class="text-[10px] font-black text-slate-400">{{ $log->created_at->format('d/m/Y') }}</p>
                                <p class="text-[10px] font-bold text-slate-600">{{ $log->created_at->format('H:i:s') }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[10px] font-black text-blue-600 border border-blue-100">
                                        {{ substr($log->user->name, 0, 1) }}
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">{{ $log->user->name }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase italic border
                                    @if($log->action == 'Created') bg-emerald-50 text-emerald-600 border-emerald-100
                                    @elseif($log->action == 'Updated') bg-blue-50 text-blue-600 border-blue-100
                                    @elseif($log->action == 'Deleted') bg-rose-50 text-rose-600 border-rose-100
                                    @else bg-slate-50 text-slate-600 border-slate-100
                                    @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $log->module }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs font-medium text-slate-600 text-center">{{ $log->description }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada rekaman aktivitas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div class="p-8 border-t border-slate-50">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
