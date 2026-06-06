<!-- Desktop View -->
<div class="hidden md:block overflow-x-auto rounded-3xl border border-slate-200 bg-slate-50/30">
    <table class="min-w-full text-xs md:text-sm text-center">
        <thead class="bg-white border-b border-slate-200">
            <tr>
                <th class="p-5 font-black text-slate-500 uppercase tracking-widest text-left whitespace-nowrap bg-slate-50">Alternatif</th>
                @foreach($criterias as $c)
                    <th class="p-5 font-black text-slate-500 uppercase tracking-widest whitespace-nowrap px-8 bg-slate-50 border-l border-slate-100">{{ $c->code }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @foreach($results as $res)
            <tr class="hover:bg-white transition-colors">
                <td class="p-5 font-black text-slate-800 text-left capitalize bg-white sticky left-0 shadow-[2px_0_5px_rgba(0,0,0,0.02)] whitespace-nowrap">{{ $res['name'] }}</td>
                @foreach($criterias as $c)
                    <td class="p-5 font-mono text-slate-600 px-8 border-l border-slate-50">
                        @if($key === 'original_scores')
                            <span class="font-bold text-slate-900">{{ $res['original_scores'][$c->id] }}</span>
                        @elseif($key === 'normalized_scores' && isset($type) && $type === 'normalized')
                            {{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}
                        @else
                            <span class="font-bold text-blue-600">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Mobile View -->
<div class="md:hidden space-y-8">
    @foreach($results as $res)
    <div class="bg-white rounded-3xl border-2 border-slate-100 overflow-hidden shadow-sm">
        <div class="bg-slate-900 px-5 py-4">
            <h5 class="font-black text-white text-sm uppercase tracking-tight">{{ $res['name'] }}</h5>
        </div>
        <div class="p-5 grid grid-cols-2 gap-x-6 gap-y-6 bg-slate-50/50">
            @foreach($criterias as $c)
            <div class="flex flex-col p-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.1em] mb-1.5">{{ $c->code }} • {{ $c->name }}</span>
                <span class="text-sm font-mono font-black text-slate-800">
                    @if($key === 'original_scores')
                        {{ $res['original_scores'][$c->id] }}
                    @elseif($key === 'normalized_scores' && isset($type) && $type === 'normalized')
                        {{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}
                    @else
                        <span class="text-blue-600">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</span>
                    @endif
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
