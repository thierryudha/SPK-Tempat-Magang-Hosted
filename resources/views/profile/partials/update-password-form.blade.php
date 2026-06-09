<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">Ubah Password</div>
            <div class="panel-subtitle">Gunakan password yang kuat dan unik</div>
        </div>
    </div>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="form-body">
            @if(Auth::user()->password)
                <div class="form-row single">
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini <span class="required">*</span></label>
                        <input class="form-input" type="password" name="current_password" required autocomplete="current-password" placeholder="Masukkan password lama">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                </div>
            @else
                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:12px 14px;font-size:12px;color:#1D4ED8;font-weight:600;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                    <i class="ti ti-info-circle" style="font-size:16px;margin-top:2px;"></i>
                    <div>Anda masuk menggunakan Google dan belum memiliki password lokal. Silakan atur password baru di bawah ini jika Anda ingin bisa masuk menggunakan Email dan Password.</div>
                </div>
                <!-- Dummy current_password to bypass validation if needed by Fortify/Breeze default controller, though usually it handles this or we override -->
                <input type="hidden" name="current_password" value="google_oauth_bypass_placeholder">
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password Baru <span class="required">*</span></label>
                    <input class="form-input" type="password" name="password" id="newPass" oninput="checkStrength(this.value)" required autocomplete="new-password" placeholder="Min. 8 karakter">
                    <div class="password-strength">
                        <div class="strength-bar"><div class="strength-fill" id="strengthFill" style="width:0%;background:#E2E8F0;"></div></div>
                        <span class="strength-text" id="strengthText" style="color:#94A3B8;">Belum diisi</span>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                    <input class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
            <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:12px 14px;font-size:12px;color:#64748B;font-weight:500;margin-top:16px;line-height:1.7;">
                <strong style="color:#334155;">Tips password kuat:</strong> minimal 8 karakter, kombinasi huruf besar &amp; kecil, angka, dan simbol seperti !@#$
            </div>
        </div>
        <div class="form-footer">
            <div class="save-hint"><i class="ti ti-shield-check" style="font-size:14px"></i> Enkripsi aman</div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('dashboard') }}" class="cancel-btn">Batal</a>
                <button type="submit" class="save-btn"><i class="ti ti-lock" style="font-size:14px"></i> Perbarui Password</button>
            </div>
        </div>
    </form>
</div>
