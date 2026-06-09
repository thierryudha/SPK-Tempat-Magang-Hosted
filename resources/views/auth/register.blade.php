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
                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M47.04 24.51c0-1.65-.15-3.23-.42-4.75H24v9h12.91c-.56 2.98-2.25 5.51-4.78 7.21v6h7.73c4.52-4.16 7.18-10.29 7.18-17.46z" fill="#4285F4"/>
                    <path d="M24 48c6.48 0 11.91-2.14 15.86-5.81l-7.73-6c-2.14 1.43-4.88 2.27-8.13 2.27-6.26 0-11.56-4.23-13.46-9.91H2.74v6.23C6.71 42.66 14.81 48 24 48z" fill="#34A853"/>
                    <path d="M10.54 28.55c-.48-1.43-.75-2.95-.75-4.55s.27-3.12.75-4.55V13.22H2.74C1 16.6 0 20.19 0 24s1 7.4 2.74 10.78l7.8-6.23z" fill="#FBBC05"/>
                    <path d="M24 9.73c3.52 0 6.69 1.21 9.18 3.59l6.88-6.88C35.9 2.15 30.47 0 24 0 14.81 0 6.71 5.34 2.74 13.22l7.8 6.23C12.44 13.96 17.74 9.73 24 9.73z" fill="#EA4335"/>
                </svg>
                <span class="text-[13px] font-extrabold text-slate-700 uppercase tracking-widest">Daftar dengan Google</span>
            </a>
        </div>
    </form>
</x-guest-layout>
