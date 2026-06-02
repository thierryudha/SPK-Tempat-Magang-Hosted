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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        [x-cloak] { display: none !important; }
        
        /* Layout Structure */
        .admin-layout {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: #f8fafc;
        }

        .admin-sidebar {
            width: 280px;
            background-color: #ffffff;
            border-right: 1px solid #f1f5f9;
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
            height: 80px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            flex-shrink: 0;
        }

        .admin-content {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
            background-color: #f8fafc;
        }

        /* Center all table content */
        table th, table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Keep action columns or specific columns if needed, but user requested all */
        .text-right { text-align: right !important; }
        .text-left { text-align: left !important; }

        /* Standardized Action Icons */
        .action-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f5f9; border-radius: 10px; }

        /* Responsive Fixes */
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
                padding: 0 24px;
            }
            .admin-content {
                padding: 24px;
            }
        }
    </style>
</head>
<body class="h-full antialiased text-slate-900 overflow-hidden" x-data="{ sidebarOpen: false }">
    
    <div class="admin-layout">
        
        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'open' : ''" class="admin-sidebar">
            <div class="h-20 flex items-center justify-between px-8 border-b border-slate-50 flex-shrink-0">
                <span class="text-lg font-black tracking-tighter italic text-slate-900">Moora<span class="text-blue-600">Project</span></span>
                <!-- Close Button (Mobile Only) -->
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 p-2 hover:bg-slate-50 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <nav class="flex-1 px-4 py-8 space-y-1 overflow-y-auto custom-scrollbar">
                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Dashboard
                </a>

                <div class="pt-6 pb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-4">Master Data</div>
                
                <a href="{{ route('admin.criterias.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.criterias.*') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Kriteria
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    Bidang
                </a>

                <a href="{{ route('admin.internships.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.internships.*') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Perusahaan
                </a>

                <div class="pt-6 pb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-4">User Management</div>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l-9-5 9-5 9 5-9 5zm0 0v6"></path></svg>
                    Data Mahasiswa
                </a>

                <a href="{{ route('admin.administrators.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('admin.administrators.*') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Tim Administrator
                </a>
            </nav>

            <div class="p-6 border-t border-slate-50 bg-slate-50/30">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 mb-6 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-blue-500/20 border-2 border-white transform rotate-3 group-hover:rotate-0 transition-transform">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[11px] font-black text-slate-900 truncate uppercase tracking-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-blue-600/60 uppercase tracking-widest">My Profile</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 text-[10px] font-black uppercase tracking-widest text-white bg-red-500 rounded-xl hover:bg-red-600 shadow-lg shadow-red-500/20 transition-all active:scale-95">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Mobile -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="hidden md:block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1 italic">Moora System</h2>
                        <p class="text-[10px] md:text-xs font-black text-slate-900 uppercase tracking-widest">Admin Control Panel</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 lg:gap-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 bg-slate-900 text-white rounded-xl text-[8px] md:text-[9px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span class="hidden sm:inline">Switch to User View</span>
                    </a>
                    <span class="hidden md:inline text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ now()->format('d M Y') }}</span>
                </div>
            </header>

            <!-- Overlay Mobile -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="lg:hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 transition-opacity"></div>

            <main class="admin-content custom-scrollbar">
                <div class="max-w-[1400px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

</body>
</html>
