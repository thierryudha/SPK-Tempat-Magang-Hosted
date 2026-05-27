<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Profile</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi akun administrator Anda.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Photo Section -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 text-center">
                <div class="relative inline-block mb-6">
                    <div class="w-40 h-40 rounded-full border-4 border-slate-50 shadow-xl overflow-hidden bg-slate-100 mx-auto" style="aspect-ratio: 1/1;">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-600 text-white text-4xl font-black italic rounded-full">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $user->name }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Master Administrator</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 md:p-12 rounded-[2.5rem] border border-slate-100">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3" />
                            <x-text-input id="name" name="name" type="text" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('name', $user->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" value="Email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3" />
                            <x-text-input id="email" name="email" type="email" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="photo" value="Update Foto Profil" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3" />
                        <input id="photo" name="photo" type="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-blue-600 transition-all cursor-pointer shadow-sm" />
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 italic">Ganti Password (Kosongkan jika tidak ingin ganti)</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="password" value="Password Baru" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3" />
                                <x-text-input id="password" name="password" type="password" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full bg-slate-50 border-transparent focus:bg-white transition" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl shadow-xl shadow-blue-500/20 text-[10px] font-black uppercase tracking-[0.3em]">
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
