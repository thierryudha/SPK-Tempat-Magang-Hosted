<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
        <p class="text-slate-500 text-sm mt-1">Laporan analitik data MooraProject periode ini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 text-capitalize">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Users</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Internships</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_internships'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm border border-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Criteria</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_criterias'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">MOORA Session</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_sessions'] }}</p>
            </div>
        </div>
    </div>

    <!-- MAIN TRENDS SECTION (Side-by-side Cards) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Growth Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-center mb-10 relative z-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight italic">Growth Trend</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Pendaftaran User (6 Bulan)</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 shadow-sm border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="h-64 relative z-10">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <!-- Activity Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-center mb-10 relative z-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight italic">MOORA Activity</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Intensitas Penggunaan (7 Hari)</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 shadow-sm border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="h-64 relative z-10">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- BENCHMARK & DISTRIBUTION SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10 text-capitalize">
        <!-- Benchmark Bar Chart (Colorful) -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3 italic">
                <span class="w-2 h-4 bg-emerald-500 rounded-full"></span>
                Benchmark 5 Sektor Unggulan
            </h3>
            <div class="h-80">
                <canvas id="benchmarkChart"></canvas>
            </div>
        </div>

        <!-- Distribution Doughnut -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-3 italic">
                <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                Distribusi Perusahaan
            </h3>
            <div class="h-64">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="mt-8 space-y-3">
                @foreach($categoryDist->take(3) as $dist)
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100 transition hover:bg-white hover:shadow-sm">
                    <span class="text-[10px] font-bold text-slate-600 uppercase">{{ $dist->category }}</span>
                    <span class="text-xs font-black text-blue-600">{{ $dist->count }} Unit</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Lists Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-capitalize">
        <!-- Latest Students -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-xl">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic text-capitalize">Mahasiswa Terbaru</h3>
                <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black text-blue-600 uppercase hover:underline">Lihat Semua</a>
            </div>
            <div class="p-4">
                @foreach($latest_users as $user)
                <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all group">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-400 text-xs overflow-hidden border-2 border-white shadow-md flex-shrink-0" style="aspect-ratio: 1/1;">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white text-[10px] font-black italic rounded-full">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 truncate capitalize">{{ $user->name }}</p>
                        <p class="text-[10px] font-medium text-slate-400 truncate lowercase">{{ $user->email }}</p>
                    </div>
                    <span class="text-[10px] font-bold text-slate-300">{{ $user->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Activities -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-xl">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic text-capitalize">Riwayat Perhitungan</h3>
            </div>
            <div class="p-4">
                @foreach($latest_sessions as $session)
                <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 truncate capitalize">{{ $session->user->name }}</p>
                        <p class="text-[10px] font-medium text-slate-400 truncate italic uppercase">Winner: <span class="text-blue-600 font-bold tracking-tight">{{ $session->winner_name }}</span></p>
                    </div>
                    <span class="text-[10px] font-bold text-slate-300">{{ $session->created_at->format('H:i') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            
            // 1. Growth Chart (6 Months - Line Dotted)
            new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($registrationTrends->pluck('label')) !!},
                    datasets: [{
                        data: {!! json_encode($registrationTrends->pluck('count')) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            suggestedMax: 20,
                            grid: { color: '#f1f5f9', drawBorder: false }, 
                            ticks: { 
                                stepSize: 5,
                                font: { size: 10, weight: 'bold' }, 
                                color: '#94a3b8' 
                            } 
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });

            // 2. MOORA Activity Trend (7 Days - Line Dotted)
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($sessionTrend->pluck('date')) !!},
                    datasets: [{
                        data: {!! json_encode($sessionTrend->pluck('count')) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            suggestedMax: 10,
                            grid: { color: '#f1f5f9', drawBorder: false }, 
                            ticks: { 
                                stepSize: 2,
                                font: { size: 10, weight: 'bold' }, 
                                color: '#94a3b8' 
                            } 
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });

            // 3. Distribution Doughnut
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryDist->pluck('category')) !!},
                    datasets: [{
                        data: {!! json_encode($categoryDist->pluck('count')) !!},
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6366f1', '#ec4899', '#14b8a6', '#06b6d4', '#8b5cf6', '#f43f5e', '#10b981'],
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'right', 
                            labels: { color: '#64748b', font: { size: 9, weight: 'bold' }, usePointStyle: true, padding: 12 } 
                        } 
                    },
                    cutout: '75%'
                }
            });

            // 4. Benchmark Bar Chart (Colorful - Restored)
            @php $barColors = ['#3B82F6', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981']; @endphp
            new Chart(document.getElementById('benchmarkChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($criterias->pluck('name')) !!},
                    datasets: {!! json_encode(collect($criteriaComparison)->map(function($item, $index) use ($barColors) {
                        return [
                            'label' => $item['label'],
                            'data' => $item['data'],
                            'backgroundColor' => $barColors[$index % count($barColors)],
                            'borderRadius' => 6,
                            'maxBarThickness' => 30
                        ];
                    })) !!}
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 8, weight: 'bold' }, usePointStyle: true, padding: 15 } }
                    },
                    scales: {
                        y: { min: 0, max: 5, ticks: { stepSize: 1, font: { size: 10, weight: 'bold' } }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#64748b' } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
