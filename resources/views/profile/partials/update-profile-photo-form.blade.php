<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui foto profil Anda untuk personalisasi akun.") }}
        </p>
    </header>

    <div class="mt-6 flex flex-col md:flex-row items-center md:items-start gap-10" x-data="{ imageUrl: null }">
        <!-- Upload Form (Left) -->
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex-1 space-y-6 w-full order-2 md:order-1">
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

                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="flex items-center gap-2 text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-100">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Berhasil') }}</span>
                    </div>
                @endif
            </div>
        </form>

        <!-- Preview Circle (Right) -->
        <div class="flex flex-col items-center gap-4 order-1 md:order-2 flex-shrink-0">
            <div class="relative group">
                <!-- Inner Circle with fixed size and forcing 1:1 ratio -->
                <div class="w-32 h-32 sm:w-40 h-40 rounded-full border-[6px] border-white shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden bg-slate-100 relative z-10 flex-shrink-0" 
                     style="aspect-ratio: 1 / 1; min-width: 128px; min-height: 128px;">
                    
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                             class="w-full h-full object-cover rounded-full" 
                             style="width: 100%; height: 100%; display: block;"
                             x-show="!imageUrl" />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white font-black text-4xl rounded-full" 
                             x-show="!imageUrl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <template x-if="imageUrl">
                        <img :src="imageUrl" 
                             class="w-full h-full object-cover rounded-full" 
                             style="width: 100%; height: 100%; display: block;">
                    </template>
                </div>
                
                <!-- Decorative Outer Ring -->
                <div class="absolute inset-0 rounded-full border-2 border-blue-100 scale-110 -z-0 opacity-50 group-hover:scale-125 group-hover:opacity-100 transition-all duration-700"></div>
            </div>
        </div>
    </div>
</section>
