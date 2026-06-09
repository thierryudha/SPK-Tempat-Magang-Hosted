<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">Informasi Pribadi</div>
            <div class="panel-subtitle">Data dasar akun kamu</div>
        </div>
    </div>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="form-body">
            <div class="form-section">
                <div class="form-section-title">Data Diri</div>
                
                <div class="form-row single">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="text-red-600">*</span></label>
                        <input class="form-input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email <span class="text-red-600">*</span></label>
                        <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input class="form-input" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+62 8xx xxxx xxxx">
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label class="form-label">Bio Singkat</label>
                        <textarea class="form-textarea" name="bio" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>
                </div>

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('dashboard') }}" class="cancel-btn">Batal</a>
            <div class="flex items-center gap-3">
                @if (session('status') === 'profile-updated')
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-xs text-emerald-600 font-bold">Tersimpan</span>
                @endif
                <button type="submit" class="save-btn"><i class="ti ti-check"></i> Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
