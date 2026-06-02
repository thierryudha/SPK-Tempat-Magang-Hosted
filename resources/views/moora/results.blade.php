<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Perhitungan MOORA') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[
                ['label' => 'Program MOORA', 'url' => route('moora.index')],
                ['label' => 'Hasil Perhitungan']
            ]" />
            
            <!-- Ranking Cards -->
            <div class="bg-white overflow-hidden shadow-xl rounded-[2.5rem] border border-slate-100 mb-8">
                <div class="p-8 md:p-12">
                    <h3 class="text-2xl font-black mb-8 flex items-center gap-3 text-slate-900">
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        Rekomendasi Tempat Magang Terbaik
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        @foreach(collect($results)->take(3) as $index => $res)
                        <div class="relative p-8 border-2 {{ $index == 0 ? 'border-amber-400 bg-amber-50/30 ring-4 ring-amber-50' : 'border-slate-100 bg-white' }} rounded-[2.5rem] shadow-sm transition hover:scale-[1.02]">
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-8 py-1.5 border border-slate-100 shadow-sm rounded-full font-black text-xs uppercase tracking-widest text-slate-500">
                                Rank #{{ $res['rank'] }}
                            </div>
                            <div class="text-4xl mb-4 text-center">{{ $index == 0 ? '🥇' : ($index == 1 ? '🥈' : '🥉') }}</div>
                            <div class="text-xl font-black text-slate-900 text-center mb-2 truncate capitalize">{{ $res['name'] }}</div>
                            <div class="text-[10px] font-black text-blue-600 text-center uppercase tracking-[0.2em] bg-blue-50 py-2 rounded-xl">Yi: {{ number_format($res['optimization_value'], 4) }}</div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Table (Unified Style with Tempat Magang) -->
                    <div class="bg-white overflow-hidden border border-slate-100 rounded-2xl">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100">
                                <thead class="bg-slate-900">
                                    <tr>
                                        <th class="px-8 py-5 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Rank</th>
                                        <th class="px-8 py-5 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Nama Tempat Magang</th>
                                        <th class="px-8 py-5 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Nilai Akhir (Yi)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-50">
                                    @foreach($results as $res)
                                        <tr class="{{ $res['rank'] == 1 ? 'bg-yellow-50/50' : '' }} hover:bg-slate-50 transition group">
                                            <td class="px-8 py-5 whitespace-nowrap font-black text-slate-400 text-center">#{{ $res['rank'] }}</td>
                                            <td class="px-8 py-5 whitespace-nowrap font-bold text-slate-700 capitalize text-center">{{ $res['name'] }}</td>
                                            <td class="px-8 py-5 whitespace-nowrap text-center font-black text-blue-600 font-mono italic">
                                                {{ number_format($res['optimization_value'], 4) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Steps -->
            <div x-data="{ open: false }" class="mt-12">
                <button @click="open = !open" class="flex items-center gap-2 px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-100 transition font-black text-xs uppercase tracking-widest shadow-sm">
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    <span x-text="open ? 'Sembunyikan Detail Perhitungan' : 'Tampilkan Detail Perhitungan'"></span>
                </button>

                <div x-show="open" x-transition class="mt-8 flex flex-col gap-10 md:gap-16 pb-12">
                    <!-- Step 1: Decision Matrix -->
                    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-lg border border-slate-100 overflow-hidden text-capitalize">
                        <div class="mb-8">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 1</span>
                            <h4 class="text-xl font-black text-slate-900 mt-3">Matriks Keputusan (X)</h4>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed italic">Menampilkan nilai skor asli untuk setiap kriteria pada setiap alternatif.</p>
                        </div>
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="min-w-full text-xs text-left">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="p-4 font-black text-slate-400 uppercase tracking-widest">Alternatif</th>
                                        @foreach($criterias as $c)
                                            <th class="p-4 font-black text-slate-400 uppercase tracking-widest text-center">{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($results as $res)
                                    <tr>
                                        <td class="p-4 font-bold text-slate-700 capitalize">{{ $res['name'] }}</td>
                                        @foreach($criterias as $c)
                                            <td class="p-4 font-mono text-center text-slate-600">{{ $res['original_scores'][$c->id] }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Step 2: Normalization -->
                    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-lg border border-slate-100 overflow-hidden text-capitalize">
                        <div class="mb-8">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 2</span>
                            <h4 class="text-xl font-black text-slate-900 mt-3">Normalisasi Matriks (r<sub>ij</sub>)</h4>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed italic">Menghitung nilai normalisasi dengan rumus standar MOORA.</p>
                        </div>
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="min-w-full text-xs text-left">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="p-4 font-black text-slate-400 uppercase tracking-widest">Alternatif</th>
                                        @foreach($criterias as $c)
                                            <th class="p-4 font-black text-slate-400 uppercase tracking-widest text-center">{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($results as $res)
                                    <tr>
                                        <td class="p-4 font-bold text-slate-700 capitalize">{{ $res['name'] }}</td>
                                        @foreach($criterias as $c)
                                            <td class="p-4 font-mono text-center text-slate-500">{{ number_format($res['normalized_scores'][$c->id]['normalized'], 4) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Step 3: Weighted Normalization -->
                    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-lg border border-slate-100 overflow-hidden text-capitalize">
                        <div class="mb-8">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 3</span>
                            <h4 class="text-xl font-black text-slate-900 mt-3">Matriks Terbobot (y<sub>ij</sub>)</h4>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed italic">Mengalikan nilai normalisasi dengan bobot kepentingan kriteria.</p>
                        </div>
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="min-w-full text-xs text-left">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="p-4 font-black text-slate-400 uppercase tracking-widest">Alternatif</th>
                                        @foreach($criterias as $c)
                                            <th class="p-4 font-black text-slate-400 uppercase tracking-widest text-center">{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($results as $res)
                                    <tr>
                                        <td class="p-4 font-bold text-slate-700 capitalize">{{ $res['name'] }}</td>
                                        @foreach($criterias as $c)
                                            <td class="p-4 font-mono text-center text-emerald-600 font-black">{{ number_format($res['normalized_scores'][$c->id]['weighted'], 4) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Step 4: Optimization Value -->
                    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-lg border border-slate-100 overflow-hidden text-capitalize">
                        <div class="mb-8">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 4</span>
                            <h4 class="text-xl font-black text-slate-900 mt-3">Nilai Optimasi (Yi)</h4>
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed italic italic">Finalisasi skor untuk menentukan urutan rekomendasi terbaik.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($results as $res)
                            <div class="p-6 bg-slate-50 rounded-[1.5rem] border border-slate-100 flex flex-col justify-between hover:bg-white transition hover:shadow-md">
                                <div class="flex justify-between items-start mb-4">
                                    <p class="font-black text-slate-900 capitalize">{{ $res['name'] }}</p>
                                    <span class="px-2 py-1 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-slate-400">Rank #{{ $res['rank'] }}</span>
                                </div>
                                <div class="flex items-end justify-between">
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">
                                        <div class="text-emerald-500">ΣB: {{ number_format($res['sum_benefit'], 4) }}</div>
                                        <div class="text-rose-500">ΣC: {{ number_format($res['sum_cost'], 4) }}</div>
                                    </div>
                                    <span class="text-xl font-black text-blue-600 font-mono">{{ number_format($res['optimization_value'], 4) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-start gap-4">
                <a href="{{ route('moora.index') }}" class="px-8 py-4 text-slate-500 font-black hover:text-slate-700 transition text-sm md:text-base">Kembali</a>
                <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-100 transition transform active:scale-95 text-sm md:text-base text-center">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
