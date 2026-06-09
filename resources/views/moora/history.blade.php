<x-app-layout>
    <style>
        /* Stat Cards */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 28px; }
        .stat-card {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.blue { background: #EFF6FF; color: #2563EB; }
        .stat-icon.green { background: #F0FDF4; color: #16A34A; }
        .stat-icon.amber { background: #FFFBEB; color: #D97706; }
        .stat-icon.purple { background: #F5F3FF; color: #7C3AED; }
        .stat-label { font-size: 11px; color: #94A3B8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .stat-value { font-size: 22px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; }

        /* Layout Area */
        .content-area { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }

        /* Panels */
        .panel {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
        }
        .panel-header {
            padding: 20px 24px;
            border-bottom: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }
        .panel-subtitle { font-size: 12px; color: #94A3B8; margin-top: 2px; }

        /* Filter Bar */
        .filter-bar {
            padding: 14px 24px;
            border-bottom: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-box {
            flex: 1;
            min-width: 200px;
            height: 36px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 0 12px 0 34px;
            font-size: 13px;
            color: #334155;
            background: #F8FAFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
            outline: none;
        }
        .search-box:focus { border-color: #2563EB; background-color: #fff; }

        .filter-chip {
            height: 32px;
            padding: 0 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #E2E8F0;
            background: #fff;
            color: #64748B;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .filter-chip.active { background: #EFF6FF; color: #2563EB; border-color: #BFDBFE; }
        .filter-chip:hover:not(.active) { background: #F8FAFC; }

        .sort-select {
            height: 32px;
            padding: 0 30px 0 10px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 12px;
            color: #64748B;
            background: #fff;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        /* History List */
        .history-list { padding: 8px 0; }
        .history-item {
            padding: 18px 24px;
            border-bottom: 0.5px solid #F8FAFC;
            cursor: pointer;
            transition: background 0.12s;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .history-item:hover { background: #FAFBFC; }
        .history-item.selected { background: #EFF6FF; border-left: 3px solid #2563EB; padding-left: 21px; }
        .history-item:last-child { border-bottom: none; }

        .item-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: #EFF6FF;
            display: flex; align-items: center; justify-content: center;
            color: #2563EB; font-size: 18px;
            flex-shrink: 0; margin-top: 2px;
        }

        .item-body { flex: 1; min-width: 0; }
        .item-title { font-size: 14px; font-weight: 700; color: #0F172A; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .item-meta { font-size: 12px; color: #94A3B8; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .meta-dot { width: 3px; height: 3px; border-radius: 50%; background: #CBD5E1; }

        .item-right { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }
        .score-badge {
            font-size: 13px; font-weight: 800; color: #1D4ED8;
            background: #DBEAFE; border-radius: 8px;
            padding: 3px 10px; letter-spacing: -0.3px;
        }
        .rank-pill {
            font-size: 11px; font-weight: 700;
            padding: 2px 8px; border-radius: 6px;
            display: flex; align-items: center; gap: 4px;
        }
        .rank-1 { background: #FEF9C3; color: #A16207; }

        .criteria-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px; }
        .criteria-tag {
            font-size: 10px; font-weight: 600;
            background: #F1F5F9; color: #64748B;
            padding: 2px 8px; border-radius: 5px;
        }

        /* Pagination */
        .pagination-container {
            padding: 14px 24px;
            border-top: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-info { font-size: 12px; color: #94A3B8; font-weight: 600; }
        .page-btns { display: flex; gap: 4px; }
        .page-btn {
            width: 30px; height: 30px; border-radius: 7px;
            border: 1px solid #E2E8F0;
            background: #fff;
            font-size: 12px; font-weight: 700;
            color: #64748B; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
        }
        .page-btn.active { background: #2563EB; color: #fff; border-color: #2563EB; }
        .page-btn:hover:not(.active) { background: #F8FAFC; }

        /* Detail Panel */
        .detail-panel { display: flex; flex-direction: column; gap: 16px; }
        .detail-card {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
        }
        .detail-header {
            padding: 20px 20px 14px;
            border-bottom: 0.5px solid #F1F5F9;
        }
        .detail-label { font-size: 10px; font-weight: 700; color: #2563EB; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
        .detail-company { font-size: 17px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px; margin-bottom: 2px; }
        .detail-category { font-size: 12px; color: #94A3B8; font-weight: 600; }

        .winner-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #FFFBEB; border: 1px solid #FEF3C7;
            border-radius: 8px; padding: 4px 10px;
            font-size: 12px; font-weight: 700; color: #A16207;
            margin-top: 10px;
        }

        .yi-score {
            padding: 16px 20px;
            background: #EFF6FF;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 0.5px solid #DBEAFE;
        }
        .yi-label { font-size: 11px; font-weight: 700; color: #2563EB; text-transform: uppercase; letter-spacing: 0.05em; }
        .yi-value { font-size: 24px; font-weight: 800; color: #1D4ED8; letter-spacing: -1px; }

        /* Ranking List */
        .ranking-list { padding: 12px 20px 16px; }
        .ranking-row {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 0;
            border-bottom: 0.5px solid #F8FAFC;
        }
        .ranking-row:last-child { border-bottom: none; }
        .rank-num {
            width: 22px; height: 22px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800;
        }
        .rank-num.r1 { background: #FEF9C3; color: #A16207; }
        .rank-num.r2 { background: #F1F5F9; color: #475569; }
        .rank-num.r3 { background: #FEF3C7; color: #B45309; }
        .rank-num.rn { background: #F8FAFC; color: #94A3B8; }
        .rank-name { flex: 1; font-size: 13px; font-weight: 600; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .rank-yi { font-size: 12px; font-weight: 700; color: #2563EB; font-variant-numeric: tabular-nums; }

        .bar-track { height: 4px; background: #F1F5F9; border-radius: 2px; margin-top: 3px; overflow: hidden; }
        .bar-fill { height: 4px; background: #2563EB; border-radius: 2px; }

        /* Criteria Section */
        .criteria-section { padding: 0 20px 16px; }
        .criteria-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 7px 0;
            border-bottom: 0.5px solid #F8FAFC;
        }
        .criteria-row:last-child { border-bottom: none; }
        .criteria-name { font-size: 12px; color: #64748B; font-weight: 600; }
        .criteria-weight { font-size: 12px; font-weight: 700; color: #334155; }
        .criteria-type-b { font-size: 10px; font-weight: 700; color: #16A34A; background: #F0FDF4; padding: 1px 6px; border-radius: 4px; }
        .criteria-type-c { font-size: 10px; font-weight: 700; color: #DC2626; background: #FEF2F2; padding: 1px 6px; border-radius: 4px; }

        /* Buttons */
        .action-btn {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.12s;
            text-decoration: none;
        }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-secondary { background: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; }
        .btn-secondary:hover { background: #E2E8F0; }
        .btn-danger { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-danger:hover { background: #FEE2E2; }

        .action-btns { padding: 16px 20px; border-top: 0.5px solid #F1F5F9; display: flex; flex-direction: column; gap: 8px; }

        @media (max-width: 900px) {
            .content-area { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .detail-panel { display: none; }
        }

        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }
    </style>

    <x-breadcrumbs :links="[['label' => 'Riwayat Perhitungan']]" />

    <div class="mt-6 mb-10">
        <h1 class="page-title">Riwayat Perhitungan MOORA</h1>
        <p class="page-subtitle">Rekap seluruh sesi analisis tempat magang yang pernah kamu jalankan</p>
    </div>

    <!-- Stats Row Restored -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="ti ti-history"></i></div>
            <div>
                <div class="stat-label">Total Sesi</div>
                <div class="stat-value">{{ $totalSessionsCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="ti ti-trophy"></i></div>
            <div>
                <div class="stat-label">Terakhir Menang</div>
                <div class="stat-value" style="font-size:14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:160px;">{{ $latestSession->winner_name ?? '-' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="ti ti-users"></i></div>
            <div>
                <div class="stat-label">Rata-rata Alternatif</div>
                <div class="stat-value">{{ round($avgAlternatifs, 1) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="ti ti-calendar-event"></i></div>
            <div>
                <div class="stat-label">Bulan Ini</div>
                <div class="stat-value">{{ \App\Models\MooraSession::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count() }}</div>
            </div>
        </div>
    </div>

    <div class="content-area">
        <!-- Left Panel: List -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Daftar Sesi</div>
                    <div class="panel-subtitle">Klik sesi untuk melihat detail perhitungan</div>
                </div>
                <a href="{{ route('moora.index') }}" class="action-btn btn-primary" style="width:auto; padding:0 16px; height:34px; font-size:12px;">
                    <i class="ti ti-plus"></i> Sesi Baru
                </a>
            </div>

            <form action="{{ route('moora.history') }}" method="GET" class="filter-bar">
                <div class="relative flex-1">
                    <input name="search" class="search-box w-full" type="text" placeholder="Cari berdasarkan pemenang..." value="{{ request('search') }}">
                </div>
                
                <button type="submit" class="h-[36px] px-5 flex items-center justify-center bg-[#2563EB] text-white text-[12px] font-bold rounded-lg hover:bg-[#1D4ED8] transition-all">
                    Cari
                </button>

                <a href="{{ route('moora.history') }}" class="filter-chip {{ !request('filter') ? 'active' : '' }}">
                    <i class="ti ti-list" style="font-size:13px"></i> Semua
                </a>
                <a href="{{ route('moora.history', ['filter' => 'month']) }}" class="filter-chip {{ request('filter') === 'month' ? 'active' : '' }}">
                    <i class="ti ti-clock" style="font-size:13px"></i> Bulan ini
                </a>

                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Tertua</option>
                </select>
            </form>

            <div class="history-list" id="historyList">
                @forelse($formattedSessions as $index => $session)
                    <div class="history-item {{ $index === 0 ? 'selected' : '' }}" onclick="selectSession({{ $session['id'] }}, this)">
                        <div class="item-icon"><i class="ti ti-chart-bar"></i></div>
                        <div class="item-body">
                            <div class="item-title">{{ $session['winner'] }}</div>
                            <div class="item-meta">
                                <span><i class="ti ti-calendar" style="font-size:11px;vertical-align:-1px;margin-right:3px"></i>{{ $session['date'] }}</span>
                                <span class="meta-dot"></span>
                                <span>{{ $session['time'] }}</span>
                                <span class="meta-dot"></span>
                                <span>{{ $session['altCount'] }} perusahaan</span>
                                <span class="meta-dot"></span>
                                <span>{{ $session['criteriaCount'] }} kriteria</span>
                            </div>
                            <div class="criteria-tags">
                                <span class="criteria-tag">{{ $session['category'] }}</span>
                            </div>

                        </div>
                        <div class="item-right">
                            <div class="score-badge">{{ number_format($session['score'], 2) }}</div>
                            <div class="rank-pill rank-1">🥇 Winner</div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400">
                        <i class="ti ti-mood-empty text-4xl mb-3 opacity-20"></i>
                        <p class="font-bold">Belum ada riwayat.</p>
                        <p class="text-xs">Mulai analisis pertamamu sekarang!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($sessions->hasPages())
                <div class="pagination-container">
                    <div class="page-info">
                        Menampilkan {{ $sessions->firstItem() }}–{{ $sessions->lastItem() }} dari {{ $sessions->total() }} sesi
                    </div>
                    <div class="page-btns">
                        @if($sessions->onFirstPage())
                            <span class="page-btn opacity-50"><i class="ti ti-chevron-left"></i></span>
                        @else
                            <a href="{{ $sessions->previousPageUrl() }}" class="page-btn"><i class="ti ti-chevron-left"></i></a>
                        @endif

                        @foreach ($sessions->getUrlRange(1, $sessions->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $sessions->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if($sessions->hasMorePages())
                            <a href="{{ $sessions->nextPageUrl() }}" class="page-btn"><i class="ti ti-chevron-right"></i></a>
                        @else
                            <span class="page-btn opacity-50"><i class="ti ti-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Panel: Detail -->
        <div class="detail-panel" id="detailPanel">
            <!-- Dynamic Content -->
        </div>
    </div>

    <script>
        const formattedSessions = {!! json_encode($formattedSessions) !!};
        
        function getRankClass(i) {
            if (i === 0) return 'r1';
            if (i === 1) return 'r2';
            if (i === 2) return 'r3';
            return 'rn';
        }

        function renderDetail(session) {
            const panel = document.getElementById('detailPanel');
            if (!session) {
                panel.innerHTML = `
                    <div class="detail-card p-12 text-center text-slate-300">
                        <i class="ti ti-click text-5xl mb-3 opacity-20"></i>
                        <p class="font-bold">Pilih sesi untuk melihat detail</p>
                    </div>
                `;
                return;
            }

            panel.innerHTML = `
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-label">Sesi ${session.date}, ${session.time}</div>
                        <div class="detail-company">${session.winner}</div>
                        <div class="detail-category">${session.category}</div>
                        <div class="winner-badge">
                            <i class="ti ti-trophy" style="font-size:13px"></i>
                            Pemenang Sesi
                        </div>
                    </div>

                    <div class="yi-score">
                        <div>
                            <div class="yi-label">Nilai Optimasi (Yi)</div>
                            <div style="font-size:11px;color:#60A5FA;margin-top:2px;font-weight:600;">Skor tertinggi dari ${session.altCount} alternatif</div>
                        </div>
                        <div class="yi-value">${session.score.toFixed(2)}</div>
                    </div>

                    <div class="ranking-list">
                        <div style="font-size:11px;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                            Peringkat Lengkap
                        </div>
                        ${session.companies.map((c, i) => `
                            <div class="ranking-row">
                                <div class="rank-num ${getRankClass(i)}">${i + 1}</div>
                                <div style="flex:1">
                                    <div class="rank-name">${c.name}</div>
                                    <div class="bar-track"><div class="bar-fill" style="width:${c.bars}%"></div></div>
                                </div>
                                <div class="rank-yi">${c.yi.toFixed(2)}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <div class="detail-card">
                    <div class="panel-header" style="padding:16px 20px;">
                        <div>
                            <div class="panel-title" style="font-size:13px;">Kriteria Digunakan</div>
                            <div class="panel-subtitle">${session.criteria.length} kriteria, total 100%</div>
                        </div>
                    </div>
                    <div class="criteria-section">
                        ${session.criteria.map(c => `
                            <div class="criteria-row">
                                <div class="criteria-name">${c.name}</div>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span class="${c.type === 'benefit' ? 'criteria-type-b' : 'criteria-type-c'}">${c.type}</span>
                                    <span class="criteria-weight">${c.weight}%</span>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <div class="detail-card">
                    <div class="action-btns">
                        <a href="/moora/history/${session.id}" class="action-btn btn-primary">
                            <i class="ti ti-file-description" style="font-size:15px"></i>
                            Lihat Detail Lengkap
                        </a>
                    </div>
                </div>
            `;
        }

        function selectSession(id, el) {
            document.querySelectorAll('.history-item').forEach(i => i.classList.remove('selected'));
            el.classList.add('selected');
            const session = formattedSessions.find(s => s.id === id);
            renderDetail(session);
        }

        // Initialize with first item
        if (formattedSessions.length > 0) {
            renderDetail(formattedSessions[0]);
        } else {
            renderDetail(null);
        }
    </script>
</x-app-layout>
