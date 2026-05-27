<x-admin-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.administrators.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Administrator</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi akun administrator <span class="text-blue-600">{{ $admin->name }}</span>.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12">
            <form action="{{ route('admin.administrators.update', $admin) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="name" value="Nama Lengkap" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                    <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('name', $admin->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Alamat Email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                    <x-text-input id="email" name="email" type="email" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('email', $admin->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password Baru (Kosongkan jika tidak ganti)" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3" />
                    <x-text-input id="password" name="password" type="password" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full justify-center bg-slate-900 hover:bg-slate-800 py-4 rounded-2xl shadow-xl shadow-slate-900/20 text-xs font-black uppercase tracking-[0.2em]">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
