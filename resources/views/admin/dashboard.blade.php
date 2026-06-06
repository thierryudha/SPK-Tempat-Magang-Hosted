<x-admin-layout>
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Intelligence Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1 font-bold uppercase tracking-widest text-[10px]">Pusat Kendali Analitik dan Tren Magang Mahasiswa.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.export.users') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Mhs
            </a>
            <a href="{{ route('admin.export.sessions') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Hasil
            </a>
        </div>
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Most Compared Companies -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] flex items-center gap-3 mb-8">
                <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                Top Compared Companies
            </h3>
            <div class="h-64">
                <canvas id="topComparedChart"></canvas>
            </div>
        </div>

        <!-- Potential Winners Trend -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] flex items-center gap-3 mb-8">
                <span class="w-2 h-4 bg-rose-500 rounded-full"></span>
                Potential Winners (Appearances)
            </h3>
            <div class="h-64">
                <canvas id="potentialWinnersChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Criteria Weight Priorities -->
        <div class="lg:col-span-1 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg">
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
        <div class="lg:col-span-1 bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-xl">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] italic">Aktivitas Terbaru</h3>
            </div>
            <div class="p-4 space-y-3">
                @foreach($latest_sessions as $session)
                <div class="p-3 bg-slate-50/50 border border-slate-100 rounded-2xl hover:border-blue-200 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-[10px] font-black text-slate-700 truncate uppercase">{{ $session->user->name }}</p>
                        <span class="text-[8px] font-black text-slate-300 uppercase shrink-0">{{ $session->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase truncate">Winner: <span class="text-blue-600">{{ $session->winner_name }}</span></p>
                </div>
                @endforeach
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
                        y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { precision: 0, font: { size: 9, weight: 'bold' }, color: '#94a3b8' } },
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
                        y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { precision: 0, font: { size: 9, weight: 'bold' }, color: '#94a3b8' } },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });

            // 3. Top Compared Companies Chart
            new Chart(document.getElementById('topComparedChart'), {
                type: 'bar',
                indexAxis: 'y',
                data: {
                    labels: {!! json_encode($topCompared->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($topCompared->pluck('total')) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 8,
                        barThickness: 15
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 8, weight: 'bold' }, color: '#94a3b8' } },
                        y: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, color: '#475569' } }
                    }
                }
            });

            // 4. Potential Winners Chart
            new Chart(document.getElementById('potentialWinnersChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($potentialWinners->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($potentialWinners->pluck('top_appearance')) !!},
                        backgroundColor: ['#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6'],
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'right', labels: { font: { size: 8, weight: 'bold' }, usePointStyle: true, padding: 10 } } 
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</x-admin-layout>
