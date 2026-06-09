<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-lg font-black text-red-600 uppercase tracking-tight">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-xs text-gray-500 font-bold">
            {{ __('Setelah akun dihapus, semua sumber daya dan data Anda akan dihapus secara permanen. Harap unduh data Anda sebelum melakukan ini.') }}
        </p>
    </header>

    <button
        class="btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-xs text-gray-600 font-bold">
                {{ __('Sekali dihapus, semua data tidak dapat dipulihkan. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 w-full h-11 px-4 rounded-xl border-slate-200 focus:border-red-600 focus:ring-red-600"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" class="btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="btn-danger">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
