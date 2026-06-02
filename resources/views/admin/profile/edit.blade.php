<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Profile</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi akun administrator Anda.</p>
    </div>

    <div class="space-y-6">
        <!-- Profile Photo -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-2xl border border-slate-100">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Foto Profil') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ __("Perbarui foto profil Anda untuk personalisasi akun.") }}</p>
                    </header>

                    <div class="mt-6 flex flex-col md:flex-row items-center md:items-start gap-10" x-data="{ imageUrl: null }">
                        <div class="flex flex-col items-center gap-4 flex-shrink-0">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-full border-[6px] border-white shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden bg-slate-100 relative z-10 flex-shrink-0" style="aspect-ratio: 1 / 1;">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover rounded-full" x-show="!imageUrl" />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white font-black text-4xl rounded-full" x-show="!imageUrl">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <template x-if="imageUrl">
                                        <img :src="imageUrl" class="w-full h-full object-cover rounded-full">
                                    </template>
                                </div>
                                <div class="absolute inset-0 rounded-full border-2 border-blue-100 scale-110 -z-0 opacity-50"></div>
                            </div>
                        </div>

                        <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="flex-1 space-y-6 w-full">
                            @csrf
                            @method('patch')

                            <div class="bg-slate-50 p-6 rounded-[2.5rem] border-2 border-dashed border-slate-200 hover:border-blue-400 transition-all group">
                                <x-input-label for="photo" value="{{ __('Pilih Foto Baru') }}" class="mb-3 text-slate-700 font-black uppercase text-[10px] tracking-widest" />
                                <input id="photo" name="photo" type="file" accept="image/*" 
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imageUrl = e.target.result }; reader.readAsDataURL(file); }"
                                    class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-slate-900 file:text-white hover:file:bg-blue-600 cursor-pointer transition-all" />
                                <p class="mt-3 text-[10px] text-slate-400 font-bold italic">Rekomendasi: Persegi (1:1), JPG/PNG, Max 2MB.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="bg-blue-600 hover:bg-blue-700 rounded-xl px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 transition-all active:scale-95">
                                    {{ __('Simpan Foto') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-2xl border border-slate-100">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ __("Update your account's profile information and email address.") }}</p>
                    </header>

                    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="bg-slate-900 hover:bg-blue-600 rounded-xl px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] shadow-xl transition-all active:scale-95">{{ __('Save') }}</x-primary-button>

                            @if (session('success'))
                                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="flex items-center gap-2 text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-100">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Saved.') }}</span>
                                </div>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <!-- Update Password -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-2xl border border-slate-100">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Update Password') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                    </header>

                    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div>
                            <x-input-label for="update_password_password" :value="__('New Password')" />
                            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="bg-slate-900 hover:bg-blue-600 rounded-xl px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] shadow-xl transition-all active:scale-95">{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-admin-layout>
