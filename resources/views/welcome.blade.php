<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MooraProject - SPK Tempat Magang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-[#1E293B] antialiased" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass" x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 -translate-y-4" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center relative z-20">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 text-white font-bold text-xl">M</div>
                <span class="text-xl font-extrabold tracking-tight">Moora<span class="text-blue-600">Project</span></span>
            </div>
            
            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-bold text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-blue-600 transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition transform hover:-translate-y-0.5 active:translate-y-0">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-blue-600 focus:outline-none p-2">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-transition x-cloak class="absolute top-20 left-0 w-full glass border-t border-white/40 shadow-xl flex flex-col p-6 gap-4 md:hidden z-10">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-bold text-gray-700 text-center py-3 bg-white/50 rounded-xl">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-bold text-gray-700 text-center py-3 bg-white/50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition text-center">
                            Daftar Gratis
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-44 pb-32 px-6 overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-60"></div>
        
        <div class="max-w-7xl mx-auto text-center relative z-10" x-show="show" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-y-10">
            <span class="inline-block px-4 py-1.5 mb-6 bg-blue-50 text-blue-600 text-sm font-bold rounded-full border border-blue-100 uppercase tracking-widest">
                🚀 Temukan Karir Impianmu
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 leading-[1.1]">
                Pilih Tempat Magang <br> 
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">Jauh Lebih Objektif.</span>
            </h1>
            <p class="text-lg lg:text-xl text-gray-500 max-w-2xl mx-auto mb-12 leading-relaxed">
                Gunakan kekuatan metode matematika <strong>MOORA</strong> untuk membandingkan kriteria, mengatur bobot, dan mendapatkan rekomendasi tempat magang paling sesuai untukmu.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="group px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl shadow-xl hover:bg-black transition flex items-center gap-2">
                        Masuk Ke Dashboard
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="group px-10 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition flex items-center gap-2 transform hover:-translate-y-1">
                        Coba Sekarang
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="#features" class="px-10 py-4 bg-white text-gray-700 font-bold rounded-2xl shadow-md border border-gray-100 hover:bg-gray-50 transition">
                        Pelajari Fitur
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-white px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-extrabold mb-4">Kenapa Memilih MooraProject?</h2>
                <p class="text-gray-500 max-w-xl mx-auto italic">Platform pertama yang membantu mahasiswa memilih tempat magang menggunakan pendekatan ilmiah.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-8 rounded-3xl bg-blue-50/50 hover:bg-blue-50 transition border border-transparent hover:border-blue-100 group">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">📊</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">10 Kriteria Penilaian</h3>
                    <p class="text-gray-600 leading-relaxed">Dari uang saku hingga kultur perusahaan, semua kami sediakan untuk evaluasi mendalam.</p>
                </div>
                <div class="p-8 rounded-3xl bg-indigo-50/50 hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100 group">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">⚖️</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Kustomisasi Bobot</h3>
                    <p class="text-gray-600 leading-relaxed">Tentukan sendiri prioritas pribadimu. Sistem akan menyesuaikan hasil berdasarkan keinginanmu.</p>
                </div>
                <div class="p-8 rounded-3xl bg-purple-50/50 hover:bg-purple-50 transition border border-transparent hover:border-purple-100 group">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">📈</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Visualisasi Data</h3>
                    <p class="text-gray-600 leading-relaxed">Hasil perhitungan disajikan dalam bentuk grafik radar dan ranking yang mudah dipahami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-50 border-t border-gray-100 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center text-white font-bold text-lg">M</div>
                    <span class="text-lg font-bold">MooraProject</span>
                </div>
                <p class="text-gray-400 text-sm">© 2026 MooraProject. Created with passion for students.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition">GitHub</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

                </div>
            </div>
        </div>
    </footer>
</body>
</html>
