<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Perhitungan MOORA') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :links="[
                ['label' => 'Program MOORA', 'url' => route('moora.index')],
                ['label' => 'Hasil Perhitungan']
            ]" />
            
            <!-- Ranking Cards (Top 3) -->
            <div class="bg-white overflow-hidden shadow-xl rounded-[2.5rem] border border-slate-100 mb-8 p-6 md:p-12">
                <h3 class="text-xl md:text-2xl font-black mb-10 flex items-center gap-3 text-slate-900 justify-center md:justify-start">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 shadow-sm border border-amber-100">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    Rekomendasi Terbaik
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @foreach(collect($results)->take(3) as $index => $res)
                    <div class="relative p-6 md:p-8 border-2 {{ $index == 0 ? 'border-amber-400 bg-amber-50/20 ring-4 ring-amber-50/50' : 'border-slate-100 bg-white' }} rounded-[2rem] md:rounded-[2.5rem] shadow-sm transition-all duration-300 hover:shadow-xl group">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-6 py-1 border border-slate-100 shadow-sm rounded-full font-black text-[9px] uppercase tracking-widest text-slate-500">
                            Rank #{{ $res['rank'] }}
                        </div>
                        <div class="text-4xl md:text-5xl mb-4 md:mb-6 text-center transform group-hover:scale-110 transition-transform">{{ $index == 0 ? '🥇' : ($index == 1 ? '🥈' : '🥉') }}</div>
                        <div class="text-lg md:text-xl font-black text-slate-900 text-center mb-3 truncate capitalize">{{ $res['name'] }}</div>
                        <div class="text-[9px] font-black text-blue-600 text-center uppercase tracking-[0.2em] bg-blue-50 py-2 rounded-xl border border-blue-100/50">Yi: {{ number_format($res['optimization_value'], 4) }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Main Results -->
                <div class="bg-white overflow-hidden border border-slate-100 rounded-[2rem] shadow-sm">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-center">
                            <thead class="bg-slate-900">
                                <tr>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rank</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Nama Tempat Magang</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Nilai Akhir (Yi)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($results as $res)
                                    <tr class="{{ $res['rank'] == 1 ? 'bg-yellow-50/30' : '' }} hover:bg-slate-50 transition group">
                                        <td class="px-8 py-5 font-black text-slate-400">#{{ $res['rank'] }}</td>
                                        <td class="px-8 py-5 font-bold text-slate-700 capitalize text-sm text-left">{{ $res['name'] }}</td>
                                        <td class="px-8 py-5 text-right font-black text-blue-600 font-mono italic">{{ number_format($res['optimization_value'], 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="md:hidden divide-y divide-slate-100">
                        @foreach($results as $res)
                        <div class="p-5 flex items-center justify-between {{ $res['rank'] == 1 ? 'bg-yellow-50/30' : '' }}">
                            <div class="flex items-center gap-4">
                                <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center font-black text-slate-400 text-xs">#{{ $res['rank'] }}</span>
                                <span class="font-bold text-slate-700 text-sm capitalize">{{ $res['name'] }}</span>
                            </div>
                            <span class="font-black text-blue-600 font-mono text-xs">{{ number_format($res['optimization_value'], 4) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Visual Comparison Section -->
                <div class="mt-12 md:mt-16 bg-slate-50/50 rounded-[2.5rem] md:rounded-[3.5rem] p-6 md:p-10 border border-slate-100">
                    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-stretch">
                        <!-- Left: Radar Chart -->
                        <div class="w-full lg:w-7/12 bg-white rounded-[2rem] p-4 md:p-6 border border-slate-100 shadow-sm overflow-hidden flex items-center justify-center">
                            <div class="relative h-[300px] sm:h-[400px] md:h-[450px] w-full">
                                <canvas id="comparisonRadar"></canvas>
                            </div>
                        </div>
                        
                        <!-- Right: Analysis -->
                        <div class="w-full lg:w-5/12 flex flex-col justify-between py-2">
                            <div>
                                <h4 class="text-xl font-black text-slate-900 flex items-center gap-3">
                                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                                    Analisis Performa
                                </h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2 italic">Perbandingan 3 Kandidat Teratas</p>
                                
                                <div class="space-y-3 mt-8">
                                    @foreach(collect($results)->take(3) as $index => $res)
                                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-blue-200 transition group">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ ['#3b82f6', '#10b981', '#f59e0b'][$index] }}"></span>
                                            <span class="text-[11px] font-black text-slate-800 uppercase truncate group-hover:text-blue-600 transition-colors">{{ $res['name'] }}</span>
                                            <span class="ml-auto text-[8px] font-black text-slate-300 uppercase italic">Rank #{{ $res['rank'] }}</span>
                                        </div>
                                        <p class="text-[10px] text-slate-500 leading-relaxed font-medium">
                                            Memiliki keunggulan pada: <span class="text-blue-600 font-bold italic">
                                            @php
                                                $scores = collect($res['original_scores']);
                                                $maxScore = $scores->max();
                                                $strongest = [];
                                                foreach($criterias as $c) {
                                                    if($res['original_scores'][$c->id] == $maxScore) $strongest[] = $c->name;
                                                }
                                                echo implode(' & ', array_slice($strongest, 0, 2));
                                            @endphp
                                            </span>.
                                        </p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mt-6 lg:mt-0 p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                                <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest leading-loose">
                                    * Klik pada titik grafik untuk detail kriteria. @if(count($results) > 0) Peringkat tertinggi diraih oleh <span class="text-indigo-600 font-black">{{ $results[0]['name'] }}</span>. @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Perhitungan MOORA (Dropdown Link Style) -->
            <div x-data="{ open: false }" class="mt-8 px-4 md:px-0">
                <button @click="open = !open" 
                        class="flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-all font-black text-xs uppercase tracking-widest group bg-transparent p-0 mb-8 outline-none">
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <span class="border-b-2 border-transparent group-hover:border-blue-800 pb-0.5">Detail Perhitungan MOORA</span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-12">
                    <!-- Step 1: Decision Matrix -->
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-6 md:p-12 shadow-sm">
                        <div class="mb-10">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-lg italic">Langkah 1</span>
                            <h4 class="text-xl font-black text-slate-900 mt-4">Matriks Keputusan (X)</h4>
                            <p class="text-xs text-slate-500 mt-3 leading-relaxed max-w-2xl">Membentuk matriks keputusan berdasarkan skor penilaian (1-5) yang Anda berikan untuk setiap alternatif pada setiap kriteria.</p>
                        </div>
                        @include('moora.partials.step-content', ['key' => 'original_scores', 'results' => $results, 'criterias' => $criterias])
                    </div>

                    <!-- Step 2: Normalization -->
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-6 md:p-12 shadow-sm">
                        <div class="mb-10">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest rounded-lg italic">Langkah 2</span>
                            <h4 class="text-xl font-black text-slate-900 mt-4">Normalisasi Matriks (r<sub>ij</sub>)</h4>
                            <div class="bg-slate-900 text-white p-6 rounded-2xl my-6 font-mono text-xs md:text-sm shadow-xl shadow-slate-200">
                                <span class="text-slate-400">// Rumus Normalisasi</span><br>
                                <span class="text-emerald-400">r<sub>ij</sub></span> = x<sub>ij</sub> / <span class="text-blue-400">√[Σ x<sub>ij</sub>²]</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">Normalisasi dilakukan untuk menyamakan skala berbagai kriteria yang berbeda agar nilainya dapat dibandingkan secara adil.</p>
                        </div>
                        @include('moora.partials.step-content', ['key' => 'normalized_scores', 'results' => $results, 'criterias' => $criterias, 'type' => 'normalized'])
                    </div>

                    <!-- Step 3: Weighted Normalization -->
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-6 md:p-12 shadow-sm">
                        <div class="mb-10">
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest rounded-lg italic">Langkah 3</span>
                            <h4 class="text-xl font-black text-slate-900 mt-4">Matriks Terbobot (y<sub>ij</sub>)</h4>
                            <div class="bg-slate-900 text-white p-6 rounded-2xl my-6 font-mono text-xs md:text-sm shadow-xl shadow-slate-200">
                                <span class="text-slate-400">// Rumus Pembobotan</span><br>
                                <span class="text-amber-400">y<sub>ij</sub></span> = r<sub>ij</sub> * <span class="text-emerald-400">w<sub>j</sub></span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">Nilai normalisasi dikalikan dengan bobot kepentingan (W) yang telah Anda atur. Semakin tinggi bobot, semakin besar pengaruh kriteria tersebut terhadap hasil akhir.</p>
                        </div>
                        @include('moora.partials.step-content', ['key' => 'normalized_scores', 'results' => $results, 'criterias' => $criterias, 'type' => 'weighted'])
                    </div>

                    <!-- Step 4: Yi Calculation -->
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-6 md:p-12 shadow-sm">
                        <div class="mb-10">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest rounded-lg italic">Langkah 4</span>
                            <h4 class="text-xl font-black text-slate-900 mt-4">Nilai Optimasi Akhir (Yi)</h4>
                            <div class="bg-slate-900 text-white p-6 rounded-2xl my-6 font-mono text-xs md:text-sm shadow-xl shadow-slate-200 text-center">
                                <span class="text-blue-400">Yi</span> = <span class="text-emerald-400">ΣBenefit</span> - <span class="text-rose-400">ΣCost</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">Langkah terakhir adalah menjumlahkan seluruh nilai kriteria 'Benefit' dan menguranginya dengan kriteria 'Cost'. Alternatif dengan nilai Yi tertinggi adalah pilihan terbaik.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($results as $res)
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm hover:border-blue-300 hover:bg-white transition group">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-black text-xs text-slate-800 capitalize">{{ $res['name'] }}</span>
                                    <span class="text-[9px] font-black text-slate-400 group-hover:text-blue-600 transition">#{{ $res['rank'] }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="text-[8px] font-black text-slate-400 uppercase leading-relaxed italic">
                                        <span class="text-emerald-500">ΣBenefit: {{ number_format($res['sum_benefit'], 4) }}</span><br>
                                        <span class="text-rose-500">ΣCost: {{ number_format($res['sum_cost'], 4) }}</span>
                                    </div>
                                    <span class="text-xl font-black text-blue-600 font-mono tracking-tighter">{{ number_format($res['optimization_value'], 4) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 flex flex-col sm:flex-row justify-start gap-4 pb-12">
                <a href="{{ route('moora.index') }}" class="px-8 py-4 text-slate-400 font-black hover:text-slate-600 transition text-xs uppercase tracking-widest text-center">Ulangi Perhitungan</a>
                <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-black transition transform active:scale-95 shadow-xl shadow-slate-900/20 text-xs uppercase tracking-widest text-center">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('comparisonRadar').getContext('2d');
            const topResults = {!! json_encode(collect($results)->take(3)) !!};
            const criteriaNames = {!! json_encode($criterias->pluck('name')) !!};
            const criteriaIds = {!! json_encode($criterias->pluck('id')) !!};
            const isDesktop = window.innerWidth >= 1024;

            const colors = [
                { border: '#3b82f6', background: 'rgba(59, 130, 246, 0.15)' },
                { border: '#10b981', background: 'rgba(16, 185, 129, 0.15)' },
                { border: '#f59e0b', background: 'rgba(245, 158, 11, 0.15)' }
            ];

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: criteriaNames,
                    datasets: topResults.map((res, index) => ({
                        label: res.name.toUpperCase(),
                        data: criteriaIds.map(id => res.original_scores[id]),
                        borderColor: colors[index].border,
                        backgroundColor: colors[index].background,
                        borderWidth: 3.5,
                        pointRadius: 4,
                        tension: 0.1
                    }))
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    layout: {
                        padding: isDesktop ? 20 : 10
                    },
                    scales: {
                        r: {
                            beginAtZero: true, min: 0, max: 5,
                            ticks: { 
                                stepSize: 1, 
                                display: false,
                            },
                            grid: { color: '#e2e8f0', lineWidth: 1 },
                            angleLines: { color: '#e2e8f0' },
                            pointLabels: {
                                display: isDesktop,
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: '900' },
                                color: '#475569',
                                padding: 15
                            }
                        }
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            titleFont: { size: 11, weight: 'black' },
                            bodyFont: { size: 10, weight: 'bold' },
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                title: (tooltipItems) => criteriaNames[tooltipItems[0].dataIndex],
                                label: (context) => ` ${context.dataset.label}: ${context.parsed.r} Skor`
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
