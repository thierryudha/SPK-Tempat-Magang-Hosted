<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-slate-900">Buat Akun Baru</h2>
        <p class="text-slate-500 text-sm mt-1">Daftarkan diri Anda untuk mulai menganalisis magang</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="block mt-2 w-full h-11 px-4 rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-2 w-full h-11 px-4 rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-password-input id="password" class="block mt-2 w-full h-11 px-4 rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-password-input id="password_confirmation" class="block mt-2 w-full h-11 px-4 rounded-xl border-slate-200 focus:border-blue-600 focus:ring-blue-600" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full mt-6 h-11 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2">
            Daftar Sekarang
        </button>

        <div class="mt-8 text-center text-xs font-bold text-slate-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
        </div>

        <!-- Google Register -->
        <div class="mt-6">
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-2 bg-white text-slate-400 uppercase font-black tracking-widest italic">Atau</span>
                </div>
            </div>

            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white border-2 border-slate-100 rounded-xl shadow-sm hover:border-blue-400 hover:bg-blue-50/30 transition-all active:scale-[0.98]">
                <i class="ti ti-brand-google text-lg"></i>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-widest">Daftar dengan Google</span>
            </a>
        </div>
    </form>
</x-guest-layout>
