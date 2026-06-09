<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
        @csrf
        @method('delete')

        <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight">
            {{ __('Konfirmasi Hapus Akun') }}
        </h2>

        <p class="mt-2 text-xs text-gray-500 font-bold leading-relaxed">
            {{ __('Apakah Anda yakin ingin menghapus akun ini? Seluruh data riwayat MOORA, preferensi, dan informasi profil akan dihapus secara permanen. Masukkan password Anda untuk melanjutkan.') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="w-full h-11 px-4 rounded-xl border-slate-200 focus:border-red-600 focus:ring-red-600"
                placeholder="{{ __('Password Konfirmasi') }}"
            />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" class="btn-secondary" x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </button>

            <button type="submit" class="btn-danger">
                {{ __('Hapus Sekarang') }}
            </button>
        </div>
    </form>
</x-modal>
