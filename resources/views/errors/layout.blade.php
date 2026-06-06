<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - MooraProject</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center">
        <div class="mb-8 inline-flex items-center justify-center w-24 h-24 bg-white rounded-[2rem] shadow-xl border border-slate-100 animate-bounce">
            <span class="text-4xl font-black text-blue-600">@yield('code')</span>
        </div>
        
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-4">@yield('message_title')</h1>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest leading-relaxed mb-10">
            @yield('message_detail')
        </p>

        <div class="flex flex-col gap-4">
            <a href="{{ url()->previous() }}" class="w-full py-4 bg-white border-2 border-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-50 transition transform active:scale-95 text-xs uppercase tracking-widest">
                Kembali
            </a>
            <a href="/" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 transition transform active:scale-95 text-xs uppercase tracking-widest">
                Ke Beranda Utama
            </a>
        </div>

        <div class="mt-16">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] italic">&copy; {{ date('Y') }} MooraProject Intelligence</p>
        </div>
    </div>
</body>
</html>
