<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Intelligence Dashboard</h1>
        <p class="text-slate-500 text-sm mt-1 font-bold uppercase tracking-widest text-[10px]">Pusat Kendali Analitik dan Tren Magang Mahasiswa.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Mahasiswa</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Perusahaan</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_internships'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm border border-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Sesi Perhitungan</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['total_sessions'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center gap-5 shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm border border-rose-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Rata-rata Opsi</p>
                <p class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $stats['avg_alternatives'] }} <span class="text-[10px] text-slate-400 font-bold">PT</span></p>
            </div>
        </div>
    </div>

    <!-- MAIN TRENDS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-center mb-10 relative z-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight italic">Growth Trend</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Pendaftaran Mahasiswa (6 Bulan)</p>
                </div>
            </div>
            <div class="h-64 relative z-10">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-center mb-10 relative z-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight italic">MOORA Activity</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Intensitas Perhitungan (7 Hari)</p>
                </div>
            </div>
            <div class="h-64 relative z-10">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- STRATEGIC ANALYTICS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Most Compared Companies -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] flex items-center gap-3">
                    <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                    Top 5 Most Compared Companies
                </h3>
            </div>
            <div class="h-80">
                <canvas id="topComparedChart"></canvas>
            </div>
        </div>

        <!-- Criteria Weight Priorities -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                <span class="w-2 h-4 bg-amber-500 rounded-full"></span>
                Prioritas Kriteria (Rata-rata Bobot)
            </h3>
            <div class="space-y-4">
                @foreach($criteriaWeights as $cw)
                <div>
                    <div class="flex justify-between text-[10px] font-black uppercase tracking-tight mb-2">
                        <span class="text-slate-600">{{ $cw->name }}</span>
                        <span class="text-blue-600">{{ number_format($cw->avg_weight, 1) }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full" style="width: {{ ($cw->avg_weight / 5) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- RECENT DATA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Win Rate Leaderboard -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-xl">
            <div class="p-8 border-b border-slate-50 bg-slate-900">
                <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em] italic">Win Rate Leaderboard</h3>
                <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Perusahaan Paling Sering Peringkat 1</p>
            </div>
            <div class="p-4">
                @forelse($topWinners as $index => $winner)
                <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-black {{ $index == 0 ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-400' }} text-xs">
                        #{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-slate-700 truncate uppercase">{{ $winner->winner_name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">{{ $winner->win_count }} Kali Menang</p>
                    </div>
                </div>
                @empty
                <p class="text-center py-10 text-[10px] font-bold text-slate-400 uppercase">Belum ada data kemenangan.</p>
                @endforelse
            </div>
        </div>

        <!-- Latest Activities -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-xl">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] italic">Riwayat Perhitungan Terbaru</h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($latest_sessions as $session)
                    <div class="flex items-center gap-4 p-4 bg-slate-50/50 border border-slate-100 rounded-2xl hover:border-blue-200 transition-all group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 shadow-sm border border-slate-100 flex-shrink-0">
                            @if($session->user->photo)
                                <img src="{{ asset('storage/'.$session->user->photo) }}" class="w-full h-full object-cover rounded-full">
                            @else
                                <span class="font-black text-xs">{{ substr($session->user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-black text-slate-700 truncate uppercase">{{ $session->user->name }}</p>
                            <p class="text-[9px] font-bold text-slate-400 truncate uppercase mt-0.5">Winner: <span class="text-blue-600">{{ $session->winner_name }}</span></p>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 uppercase">{{ $session->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            
            // 1. Growth Chart
            new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($registrationTrends->pluck('label')) !!},
                    datasets: [{
                        data: {!! json_encode($registrationTrends->pluck('count')) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9', drawBorder: false }, 
                            ticks: { 
                                precision: 0,
                                font: { size: 9, weight: 'bold' }, 
                                color: '#94a3b8' 
                            } 
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });

            // 2. Activity Chart
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($sessionTrend->pluck('date')) !!},
                    datasets: [{
                        data: {!! json_encode($sessionTrend->pluck('count')) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9', drawBorder: false }, 
                            ticks: { 
                                precision: 0,
                                font: { size: 9, weight: 'bold' }, 
                                color: '#94a3b8' 
                            } 
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });

            // 3. Top Compared Companies Chart (Horizontal Bar)
            new Chart(document.getElementById('topComparedChart'), {
                type: 'bar',
                indexAxis: 'y',
                data: {
                    labels: {!! json_encode($topCompared->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($topCompared->pluck('total')) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 8,
                        barThickness: 20
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } },
                        y: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#475569' } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
