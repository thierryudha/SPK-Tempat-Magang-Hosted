<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pusat Analitik Intelligence') }}
        </h2>
    </x-slot>

    <!-- Visualisation Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6 lg:py-10 bg-[#F1F5F9]/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- SECTION 1: Personal Profile & Growth -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
                <!-- User Welcome & Stats -->
                <div class="lg:col-span-8 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-12 flex flex-col md:flex-row gap-10 items-center overflow-hidden relative">
                    <div class="flex-1 z-10">
                        <div class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-6">Analisis Personal</div>
                        <h3 class="text-3xl lg:text-4xl font-black text-slate-900 mb-3 tracking-tight leading-tight">
                            {{ $bestInternshipData->name ?? 'Mulai Pilih Tempat Magang Mu' }}
                        </h3>
                        <p class="text-slate-500 text-sm mb-10 max-w-md leading-relaxed">Profil ini dirangkum berdasarkan preferensi bobot unik Anda terhadap {{ $criterias->count() }} kriteria penilaian profesional.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <div class="px-6 py-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Total Evaluasi</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-2xl font-black text-slate-800">{{ $myInternshipsCount }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold mb-1.5 uppercase">Perusahaan</span>
                                </div>
                                <p class="text-[9px] text-slate-400 mt-1 italic">Internship yang Anda simpan</p>
                            </div>
                            <div class="px-6 py-4 bg-blue-50 rounded-3xl border border-blue-100">
                                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest mb-1">Skor Rata-Rata</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-2xl font-black text-blue-600">{{ $bestInternshipData ? number_format($bestInternshipData->avg_score, 1) : '0.0' }}</span>
                                    <span class="text-[10px] text-blue-400 font-bold mb-1.5 uppercase">/ 5.0</span>
                                </div>
                                <p class="text-[9px] text-blue-400 mt-1 italic">Rerata kriteria terbaik Anda</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-80 h-80 flex-shrink-0 z-10 bg-white/50 backdrop-blur-sm rounded-[2rem] p-4 border border-slate-50 shadow-inner">
                        @if($bestInternshipData)
                            <canvas id="personalRadarChart"></canvas>
                        @else
                            <div class="h-full w-full flex items-center justify-center text-center p-6 italic text-slate-300 text-xs">Tambah & nilai tempat magang <br> untuk melihat grafik radar profil.</div>
                        @endif
                    </div>

                    <!-- Decorative background icon -->
                    <div class="absolute -right-16 -bottom-16 text-slate-100 rotate-12 pointer-events-none z-0">
                        <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                </div>

                <!-- Registration Trend (Small Card) -->
                <div class="lg:col-span-4 bg-slate-900 rounded-[2.5rem] shadow-2xl p-8 flex flex-col justify-between overflow-hidden relative">
                    <div class="relative z-10">
                        <h3 class="text-white font-black text-lg mb-1">Growth Trend</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-8">Community Activity</p>
                        <div class="h-32">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                    <div class="relative z-10 pt-6 border-t border-white/5 mt-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Total Users</p>
                                <p class="text-3xl font-black text-white">{{ $totalUsers }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20 font-black text-xs">+{{ $registrationTrends->last()->count ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Benchmarking & Distribution -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
                <!-- BENCHMARK RADAR (Replacement for Line Chart) -->
                <div class="lg:col-span-7 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 overflow-hidden relative">
                    <!-- Decorative background icon -->
                    <div class="absolute -right-20 -bottom-20 text-slate-100 pointer-events-none z-0">
                        <svg class="w-96 h-96 absolute top-0 left-0 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <svg class="w-64 h-64 absolute -top-20 -left-32 opacity-30 rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <svg class="w-48 h-48 absolute top-40 -left-10 opacity-70 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4 relative z-10">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 flex items-center gap-3 tracking-tight">
                                <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                                Benchmark Sektor Unggulan
                            </h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1 italic">Analisis Komparasi: Top 5 Sektor vs 10 Kriteria</p>
                        </div>
                    </div>
                    <div class="h-[450px] lg:h-[500px] relative z-10">
                        <canvas id="benchmarkBarChart"></canvas>
                    </div>
                </div>

                <!-- DISTRIBUTION DOUGHNUT -->
                <div class="lg:col-span-5 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 flex flex-col relative overflow-hidden">
                    <!-- Decorative background icon -->
                    <div class="absolute -left-16 -top-16 text-slate-100 pointer-events-none z-0">
                        <svg class="w-80 h-80 absolute top-0 left-0 opacity-50 -rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <svg class="w-40 h-40 absolute top-40 left-40 opacity-40 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="mb-10 relative z-10">
                        <h3 class="text-2xl font-black text-slate-900 flex items-center gap-3 tracking-tight">
                            <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                            Distribusi Bidang
                        </h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Industry Landscape Analysis</p>
                    </div>
                    <div class="h-64 lg:h-72 mb-8 relative z-10">
                        <canvas id="categoryDoughnutChart"></canvas>
                    </div>
                    <div class="mt-auto grid grid-cols-2 gap-4">
                        @foreach($treemapData->take(4) as $item)
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase truncate mb-1">{{ $item->category }}</p>
                            <p class="text-lg font-black text-slate-800">{{ $item->value }} <span class="text-[10px] font-medium text-slate-400">Pusat</span></p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Rankings & Market Insight -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- TOP 5 ELITE -->
                <div class="bg-white rounded-[2.5rem] shadow-sm p-8 border border-gray-100 relative overflow-hidden">
                    <!-- Decorative background icon -->
                    <div class="absolute -right-10 -top-10 text-slate-100 pointer-events-none z-0">
                        <svg class="w-64 h-64 absolute top-0 right-0 opacity-50 rotate-90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <svg class="w-32 h-32 absolute top-40 right-40 opacity-60 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <svg class="w-20 h-20 absolute top-10 right-60 opacity-30 rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 class="font-black text-slate-900 text-sm mb-8 flex items-center gap-2 relative z-10">
                        <span class="w-1.5 h-4 bg-yellow-400 rounded-full"></span>
                        Top 5 Elite Companies
                    </h3>
                    <div class="space-y-4">
                        @foreach($globalTopInternships as $index => $global)
                        <div class="group flex items-center gap-4 p-3 hover:bg-slate-50 rounded-2xl transition duration-300">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-xs {{ $index == 0 ? 'text-yellow-500 ring-2 ring-yellow-100' : 'text-slate-400' }}">{{ $index + 1 }}</div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition truncate">{{ $global->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $global->category }}</p>
                            </div>
                            <div class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">⭐ {{ number_format($global->avg_score, 1) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Market Insight & Action -->
                <div class="lg:col-span-2 bg-indigo-600 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden flex flex-col md:flex-row gap-10">
                    <div class="flex-1 z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-200 mb-4">Strategic Insight</p>
                        <h4 class="text-3xl font-black mb-6 leading-tight">Siap Untuk Menentukan Pilihan Terbaikmu?</h4>
                        <p class="text-indigo-100 text-sm leading-relaxed mb-10 opacity-80 italic">"Sektor {{ $treemapData->first()->category }} memiliki ketersediaan paling tinggi saat ini. Gunakan metode MOORA untuk melihat apakah mereka sesuai dengan kriteria pribadi Anda."</p>
                        <a href="{{ route('moora.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-indigo-600 font-black rounded-2xl shadow-xl hover:scale-105 transition transform active:scale-95">
                            Jalankan Program MOORA
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <!-- Stats abstract -->
                    <div class="w-full md:w-64 bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/10 z-10">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-6">Database Scan</p>
                        <div class="space-y-6">
                            <div>
                                <p class="text-2xl font-black">{{ $totalInternships }}</p>
                                <p class="text-[9px] font-bold text-indigo-200 uppercase">Opportunities Found</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black">{{ $totalUsers * 10 }}+</p>
                                <p class="text-[9px] font-bold text-indigo-200 uppercase">Evaluations Run</p>
                            </div>
                        </div>
                    </div>
                    <!-- Abstract shape -->
                    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#94A3B8';

            // 1. PERSONAL RADAR CHART
            @if($bestInternshipData)
            new Chart(document.getElementById('personalRadarChart'), {
                type: 'radar',
                data: {
                    labels: {!! json_encode($personalChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($personalChartData['values']) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { 
                        r: { 
                            min: 1, max: 5, 
                            ticks: { display: false, stepSize: 1 },
                            grid: { color: '#CBD5E1', lineWidth: 2 },
                            angleLines: { color: '#CBD5E1', lineWidth: 2 },
                            pointLabels: { font: { size: 9, weight: 'bold' }, color: '#64748B' }
                        } 
                    }
                }
            });
            @endif

            // 2. USER GROWTH
            new Chart(document.getElementById('userGrowthChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($registrationTrends->pluck('label')) !!},
                    datasets: [{
                        label: 'Total Users',
                        data: {!! json_encode($registrationTrends->pluck('count')) !!},
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#fff',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointHoverRadius: 6,
                        pointHitRadius: 10
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#0f172a',
                            bodyColor: '#0f172a',
                            titleFont: { weight: 'bold' },
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Users';
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            display: true, 
                            beginAtZero: true,
                            grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false },
                            ticks: { 
                                color: 'rgba(255,255,255,0.4)', 
                                font: { size: 9 },
                                stepSize: 5,
                                callback: function(value) { if (value % 5 === 0) return value; }
                            }
                        },
                        x: { 
                            display: true, 
                            grid: { display: false }, 
                            ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 8, weight: 'bold' } } 
                        }
                    }
                }
            });

            // 3. DOUGHNUT CHART
            new Chart(document.getElementById('categoryDoughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($treemapData->pluck('category')) !!},
                    datasets: [{
                        data: {!! json_encode($treemapData->pluck('value')) !!},
                        backgroundColor: ['#6366F1', '#8B5CF6', '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#EC4899', '#14B8A6'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: window.innerWidth < 768 ? 'bottom' : 'right', 
                            labels: { boxWidth: 10, usePointStyle: true, font: { size: 10, weight: 'bold' } } 
                        }
                    },
                    cutout: '75%'
                }
            });

            // 4. BENCHMARK BAR CHART (Replacement for Radar Chart)
            @php
                $barColors = ['#3B82F6', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981'];
            @endphp
            new Chart(document.getElementById('benchmarkBarChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($criterias->pluck('name')) !!},
                    datasets: {!! json_encode(collect($criteriaComparison)->map(function($item, $index) use ($barColors) {
                        return [
                            'label' => $item['label'],
                            'data' => $item['data'],
                            'backgroundColor' => $barColors[$index % count($barColors)],
                            'borderRadius' => 8,
                            'maxBarThickness' => 40
                        ];
                    })) !!}
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                boxWidth: 12, 
                                usePointStyle: true, 
                                font: { size: 11, weight: 'bold' },
                                padding: 20
                            } 
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 5,
                            ticks: { 
                                stepSize: 1,
                                font: { size: 11, weight: 'bold' }
                            },
                            grid: {
                                color: '#F1F5F9',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { size: 10, weight: 'bold' },
                                color: '#64748B'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
