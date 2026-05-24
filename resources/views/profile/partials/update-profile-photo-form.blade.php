<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui foto profil Anda untuk personalisasi akun.") }}
        </p>
    </header>

    <div class="mt-6 flex items-center gap-6">
        <div class="shrink-0">
            @if(Auth::user()->photo)
                <img class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
            @else
                <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-xl">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="photo" value="{{ __('Upload Foto Baru') }}" />
                <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Simpan Foto') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Berhasil disimpan.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>
