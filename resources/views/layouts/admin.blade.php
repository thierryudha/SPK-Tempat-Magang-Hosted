<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }
        
        [x-cloak] { display: none !important; }
        
        /* Layout Structure */
        .admin-layout {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .admin-sidebar {
            width: 280px;
            background-color: #ffffff;
            border-right: 0.5px solid #E2E8F0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            flex-shrink: 0;
            transition: all 0.3s ease-in-out;
            z-index: 50;
        }

        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            height: 100vh;
            position: relative;
        }

        .admin-header {
            height: 64px;
            background-color: #ffffff;
            border-bottom: 1px solid #E8EFF6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .admin-content {
            flex: 1;
            overflow-y: auto;
            padding: 32px;
        }

        /* Sidebar Nav */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
            color: #64748B;
            text-decoration: none;
        }
        .nav-link:hover {
            background-color: #F1F5F9;
            color: #0F172A;
        }
        .nav-link.active {
            background-color: #EFF6FF;
            color: #2563EB;
        }
        .nav-link i {
            font-size: 18px;
        }

        .section-label {
            padding: 24px 16px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }

        /* Pagination & Search Styles */
        .pagination-container {
            padding: 14px 24px;
            border-top: 0.5px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .page-info { font-size: 12px; color: #94A3B8; font-weight: 600; }
        .page-btns { display: flex; gap: 4px; }
        .page-btn {
            width: 32px; height: 32px; border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: #fff;
            font-size: 12px; font-weight: 700;
            color: #64748B; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .page-btn.active { background: #2563EB; color: #fff; border-color: #2563EB; }
        .page-btn:hover:not(.active) { background: #F8FAFC; border-color: #CBD5E1; color: #0F172A; }
        .page-btn.disabled { opacity: 0.5; cursor: not-allowed; }

        .search-box {
            height: 40px;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 0 12px 0 40px;
            font-size: 13px;
            color: #334155;
            background: #F8FAFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 14px center;
            outline: none;
            transition: all 0.2s;
            width: 100%;
        }
        .search-box:focus { border-color: #2563EB; background-color: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }

        .filter-select {
            height: 40px;
            padding: 0 34px 0 14px;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            font-size: 13px;
            color: #334155;
            background: #F8FAFC;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2394A3B8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            transition: all 0.2s;
        }
        .filter-select:focus { border-color: #2563EB; background-color: #fff; }

        @media (max-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-header {
                padding: 0 20px;
            }
            .admin-content {
                padding: 24px;
            }
        }
    </style>
</head>
<body class="h-full antialiased" x-data="{ sidebarOpen: false }">
    
    <div class="admin-layout">
        
        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'open' : ''" class="admin-sidebar">
            <div class="h-[64px] flex items-center justify-between px-8 border-b border-[#E8EFF6] flex-shrink-0">
                <span class="text-xl font-extrabold tracking-tight text-[#0F172A]">Moora<span class="text-[#2563EB]">Project</span></span>
                <!-- Close Button (Mobile Only) -->
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 p-2 hover:bg-slate-50 rounded-xl transition-all">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    Dashboard
                </a>

                <div class="section-label">Master Data</div>
                
                <a href="{{ route('admin.criterias.index') }}" class="nav-link {{ request()->routeIs('admin.criterias.*') ? 'active' : '' }}">
                    <i class="ti ti-list-details"></i>
                    Kriteria
                </a>

                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ti ti-category"></i>
                    Bidang
                </a>

                <a href="{{ route('admin.internships.index') }}" class="nav-link {{ request()->routeIs('admin.internships.*') ? 'active' : '' }}">
                    <i class="ti ti-building"></i>
                    Perusahaan Global
                </a>

                <a href="{{ route('admin.user-internships.index') }}" class="nav-link {{ request()->routeIs('admin.user-internships.*') ? 'active' : '' }}">
                    <i class="ti ti-users-group"></i>
                    Kontribusi Mahasiswa
                </a>

                <div class="section-label">User Management</div>

                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    Data Mahasiswa
                </a>

                <a href="{{ route('admin.administrators.index') }}" class="nav-link {{ request()->routeIs('admin.administrators.*') ? 'active' : '' }}">
                    <i class="ti ti-shield-check"></i>
                    Tim Administrator
                </a>

                <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                    <i class="ti ti-history"></i>
                    Log Aktivitas
                </a>
            </nav>

            <div class="p-6 border-t border-[#E8EFF6] bg-white">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 mb-6 group">
                    <div class="w-10 h-10 rounded-xl bg-[#2563EB] flex items-center justify-center text-white font-extrabold text-sm shadow-lg shadow-blue-500/10 border-2 border-white transform transition-transform group-hover:scale-105">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[13px] font-bold text-[#0F172A] truncate tracking-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] font-medium text-[#64748B] uppercase tracking-wider">Administrator</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-[12px] font-bold text-white bg-[#DC2626] rounded-[10px] hover:bg-[#B91C1C] transition-all active:scale-[0.98] shadow-sm shadow-red-500/20">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Mobile -->
                    <button type="button" @click.stop="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
                        <i class="ti ti-menu-2"></i>
                    </button>
                    <div>
                        <h2 class="hidden md:block text-[11px] font-bold text-[#94A3B8] uppercase tracking-widest mb-0.5">Sistem Moora</h2>
                        <p class="text-[14px] font-extrabold text-[#0F172A] tracking-tight">Admin Control Panel</p>
                    </div>
                </div>
            </header>

            <!-- Overlay Mobile -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="lg:hidden fixed inset-0 bg-[#0F172A]/40 backdrop-blur-sm z-40 transition-opacity"></div>

            <main class="admin-content custom-scrollbar">
                <div class="max-w-[1400px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
