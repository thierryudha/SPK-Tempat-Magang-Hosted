<section>
    <header class="mb-6">
        <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight">{{ __('Foto Profil') }}</h2>
        <p class="mt-1 text-xs text-gray-500 font-bold">{{ __("Perbarui foto profil Anda untuk personalisasi akun.") }}</p>
    </header>

    <div class="mt-6 flex flex-col md:flex-row items-center md:items-start gap-10" x-data="{ imageUrl: null }">
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex-1 space-y-6 w-full">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="photo" value="{{ __('Pilih Foto Baru') }}" class="text-slate-700 font-black uppercase text-[10px] tracking-widest" />
                <input id="photo" name="photo" type="file" accept="image/*" 
                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imageUrl = e.target.result }; reader.readAsDataURL(file); }"
                    class="mt-2 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-2 file:border-blue-600 file:text-[10px] file:font-black file:uppercase file:bg-white file:text-blue-600 hover:file:bg-blue-50 cursor-pointer" />
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">{{ __('Simpan Foto') }}</button>
            </div>
        </form>

        <div class="flex flex-col items-center gap-4">
            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover" x-show="!imageUrl" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-black text-4xl" x-show="!imageUrl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <template x-if="imageUrl">
                    <img :src="imageUrl" class="w-full h-full object-cover">
                </template>
            </div>
        </div>
    </div>
</section>
