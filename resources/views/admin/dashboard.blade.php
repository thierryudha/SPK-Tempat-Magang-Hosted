<x-admin-layout>
    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container { display: flex; flex-direction: column; gap: 24px; }
        
        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .stat-card { 
            background: #fff; border: 0.5px solid #E2E8F0; border-radius: 16px; padding: 24px; 
            display: flex; align-items: center; gap: 16px; position: relative; overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05); }
        .stat-icon { 
            width: 48px; height: 48px; border-radius: 14px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 22px; flex-shrink: 0; z-index: 2;
        }
        .stat-value { font-size: 24px; font-weight: 800; color: #0F172A; line-height: 1; margin-top: 4px; }
        .stat-label { font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.08em; }
        .stat-pattern { position: absolute; right: -10px; top: -10px; font-size: 80px; opacity: 0.03; transform: rotate(-15px); pointer-events: none; }

        /* Layout Grids */
        .grid-main { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        .grid-secondary { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; }

        /* Panels */
        .panel { background: #fff; border: 0.5px solid #E2E8F0; border-radius: 16px; display: flex; flex-direction: column; height: 100%; }
        .panel-header { padding: 20px 24px; border-bottom: 0.5px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between; }
        .panel-title { font-size: 15px; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 10px; }
        .panel-body { padding: 24px; flex: 1; }
        .panel-footer { padding: 16px 24px; border-top: 0.5px solid #F1F5F9; background: #FAFBFC; border-radius: 0 0 16px 16px; }

        /* Lists */
        .list-stack { display: flex; flex-direction: column; }
        .list-item { padding: 14px 24px; border-bottom: 1px solid #F8FAFC; display: flex; align-items: center; gap: 14px; transition: background 0.2s; }
        .list-item:hover { background: #FAFBFC; }
        .list-item:last-child { border-bottom: none; }
        .avatar-small { width: 34px; height: 34px; border-radius: 10px; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0; }
        
        /* Badges */
        .badge { font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 2px 8px; border-radius: 6px; letter-spacing: 0.02em; }
        .badge-blue { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .badge-amber { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
        .badge-emerald { background: #F0FDF4; color: #16A34A; border: 1px solid #DCFCE7; }

        /* Quick Actions */
        .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .action-btn { 
            padding: 12px; border-radius: 12px; border: 1px solid #E2E8F0; background: #fff;
            display: flex; flex-direction: column; align-items: center; gap: 8px; text-align: center;
            transition: all 0.2s; text-decoration: none;
        }
        .action-btn:hover { border-color: #2563EB; background: #EFF6FF; }
        .action-btn i { font-size: 20px; color: #2563EB; }
        .action-btn span { font-size: 11px; font-weight: 700; color: #475569; }

        @media (max-width: 1200px) {
            .grid-main, .grid-secondary { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
    @endpush

    <div class="dashboard-container">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-[12px] font-bold text-[#94A3B8] uppercase tracking-[0.15em] mb-1">Overview</div>
                <h1 class="text-[28px] font-[900] text-[#0F172A] tracking-tight">Dashboard Admin</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white border border-[#E2E8F0] rounded-xl flex items-center gap-2 shadow-sm">
                    <i class="ti ti-calendar text-[#2563EB]"></i>
                    <span class="text-[13px] font-bold text-[#475569]">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- TOP STATS -->
        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="stat-card">
                <div class="stat-icon bg-blue-50 text-blue-600"><i class="ti ti-users"></i></div>
                <div>
                    <div class="stat-label">Total Mahasiswa</div>
                    <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                </div>
                <i class="ti ti-users stat-pattern"></i>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-emerald-50 text-emerald-600"><i class="ti ti-building"></i></div>
                <div>
                    <div class="stat-label">Data Global PT</div>
                    <div class="stat-value">{{ number_format($stats['total_internships']) }}</div>
                </div>
                <i class="ti ti-building stat-pattern"></i>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-indigo-50 text-indigo-600"><i class="ti ti-building-community"></i></div>
                <div>
                    <div class="stat-label">Kontribusi MHS</div>
                    <div class="stat-value">{{ number_format($stats['total_user_internships']) }}</div>
                </div>
                <i class="ti ti-building-community stat-pattern"></i>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-amber-50 text-amber-600"><i class="ti ti-chart-bar"></i></div>
                <div>
                    <div class="stat-label">Sesi Analisis</div>
                    <div class="stat-value">{{ number_format($stats['total_sessions']) }}</div>
                </div>
                <i class="ti ti-chart-bar stat-pattern"></i>
            </div>
        </div>

        <!-- MAIN CHARTS -->
        <div class="grid-main">
            <!-- Growth Chart -->
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <h3 class="panel-title"><i class="ti ti-chart-line text-blue-600"></i> Pertumbuhan Pengguna</h3>
                    <div class="badge badge-blue">6 BULAN TERAKHIR</div>
                </div>
                <div class="panel-body">
                    <canvas id="growthChart" height="300"></canvas>
                </div>
            </div>

            <!-- Distribution Chart -->
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <h3 class="panel-title"><i class="ti ti-chart-pie text-emerald-600"></i> Sektor Industri</h3>
                </div>
                <div class="panel-body flex flex-col items-center justify-center">
                    <div style="width: 100%; max-width: 220px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <div class="mt-6 w-full space-y-2">
                        @foreach($categoryDist->take(3) as $dist)
                            <div class="flex justify-between items-center text-[12px]">
                                <span class="font-bold text-[#64748B] flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ ['#2563EB', '#10B981', '#F59E0B'][$loop->index] }}"></span>
                                    {{ $dist->category }}
                                </span>
                                <span class="font-extrabold text-[#0F172A]">{{ $dist->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-secondary">
            <!-- Top Winners -->
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <h3 class="panel-title"><i class="ti ti-trophy text-amber-500"></i> Top 5 Perusahaan</h3>
                </div>
                <div class="list-stack">
                    @forelse($topWinners->take(5) as $winner)
                        <div class="list-item">
                            <div class="avatar-small bg-amber-50 text-amber-600"><i class="ti ti-award"></i></div>
                            <div class="flex-1">
                                <div class="text-[13px] font-bold text-[#0F172A] truncate w-[140px]">{{ $winner->winner_name }}</div>
                                <div class="text-[11px] text-[#94A3B8] font-bold">{{ $winner->win_count }}x Juara 1</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-[12px] text-slate-400">Belum ada data</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <h3 class="panel-title"><i class="ti ti-history text-emerald-500"></i> Aktivitas Terbaru</h3>
                </div>
                <div class="list-stack">
                    @forelse($latest_logs as $log)
                        <div class="list-item">
                            <div class="avatar-small bg-emerald-50 text-emerald-600">
                                @if($log->action == 'Created') <i class="ti ti-plus"></i>
                                @elseif($log->action == 'Updated') <i class="ti ti-edit"></i>
                                @elseif($log->action == 'Deleted') <i class="ti ti-trash"></i>
                                @else <i class="ti ti-history"></i>
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="text-[13px] font-bold text-[#0F172A] flex justify-between">
                                    <span class="truncate">{{ $log->user->name }}</span>
                                    <span class="text-[10px] text-[#94A3B8] font-medium">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-[11px] text-[#64748B] font-medium truncate">{{ $log->description }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-[12px] text-slate-400">Belum ada rekaman aktivitas</div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Access -->
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <h3 class="panel-title"><i class="ti ti-rocket text-indigo-600"></i> Akses Cepat</h3>
                </div>
                <div class="panel-body">
                    <div class="quick-actions">
                        <a href="{{ route('admin.internships.create') }}" class="action-btn">
                            <i class="ti ti-plus"></i>
                            <span>Tambah PT</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="action-btn">
                            <i class="ti ti-users"></i>
                            <span>Kelola MHS</span>
                        </a>
                        <a href="{{ route('admin.criterias.index') }}" class="action-btn">
                            <i class="ti ti-list-details"></i>
                            <span>Kriteria</span>
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="action-btn">
                            <i class="ti ti-history"></i>
                            <span>Audit Log</span>
                        </a>
                    </div>
                    <div class="mt-6 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-indigo-200">?</div>
                            <div class="text-[11px] font-bold text-indigo-900 leading-tight">Butuh bantuan pengolahan data MOORA?</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Activity Chart (Full Width) -->
        <div class="panel shadow-sm">
            <div class="panel-header">
                <h3 class="panel-title"><i class="ti ti-calendar-stats text-indigo-500"></i> Frekuensi Analisis Harian</h3>
                <div class="text-[12px] font-bold text-[#94A3B8]">7 HARI TERAKHIR</div>
            </div>
            <div class="panel-body">
                <canvas id="activityChart" height="200"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#94A3B8';
        Chart.defaults.scale.grid.color = '#F8FAFC';

        // Growth Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($registrationTrends->pluck('label')) !!},
                datasets: [{
                    data: {!! json_encode($registrationTrends->pluck('count')) !!},
                    borderColor: '#2563EB',
                    borderWidth: 4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#2563EB',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.1)');
                        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');
                        return gradient;
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        border: { display: false },
                        min: 0,
                        suggestedMax: 5,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
                        }
                    },
                    x: { border: { display: false } }
                }
            }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryDist->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($categoryDist->pluck('count')) !!},
                    backgroundColor: ['#2563EB', '#10B981', '#F59E0B', '#6366F1', '#EC4899', '#8B5CF6'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { legend: { display: false } }
            }
        });

        // Activity Chart
        new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($sessionTrend->pluck('date')) !!},
                datasets: [{
                    data: {!! json_encode($sessionTrend->pluck('count')) !!},
                    backgroundColor: '#6366F1',
                    borderRadius: 8,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, border: { display: false } },
                    x: { border: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
