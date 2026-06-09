<x-app-layout>
    <style>
        .page { background: #F8FAFC; min-height: 100vh; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: #0F172A; }
        .main { padding: 32px; max-width: 1200px; margin: 0 auto; }

        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Main grid */
        .profile-grid { display: grid; grid-template-columns: 300px 1fr; gap: 20px; align-items: start; }

        /* Panel */
        .panel { background: #fff; border: 0.5px solid #E2E8F0; border-radius: 16px; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 20px 24px; border-bottom: 0.5px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between; }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }
        .panel-subtitle { font-size: 12px; color: #94A3B8; margin-top: 2px; }

        /* Profile card (left) */
        .profile-card-body { padding: 28px 24px; text-align: center; }

        .avatar-wrap { position: relative; display: inline-block; margin-bottom: 16px; }
        .avatar-large {
            width: 88px; height: 88px; border-radius: 50%;
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 28px; font-weight: 800;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #DBEAFE;
            object-fit: cover;
        }
        .avatar-edit-btn {
            position: absolute; bottom: 2px; right: 2px;
            width: 26px; height: 26px; border-radius: 50%;
            background: #2563EB; color: #fff; border: 2px solid #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 12px;
            transition: background 0.12s;
        }
        .avatar-edit-btn:hover { background: #1D4ED8; }
        
        .avatar-delete-btn {
            position: absolute; bottom: 2px; left: 2px;
            width: 26px; height: 26px; border-radius: 50%;
            background: #FEF2F2; color: #DC2626; border: 2px solid #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 12px; transition: all 0.12s;
        }
        .avatar-delete-btn:hover { background: #FEE2E2; color: #B91C1C; }

        .profile-name { font-size: 18px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px; margin-bottom: 12px; }
        .profile-prodi {
            display: inline-flex; align-items: center; gap: 6px;
            background: #EFF6FF; color: #2563EB;
            border-radius: 8px; padding: 5px 12px;
            font-size: 12px; font-weight: 700;
        }

        /* Danger zone */
        .danger-zone { padding: 20px 24px; }
        .danger-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; border-radius: 10px;
            border: 1px solid #FECACA; background: #FEF2F2; margin-bottom: 10px;
        }
        .danger-info-title { font-size: 13px; font-weight: 700; color: #B91C1C; margin-bottom: 2px; }
        .danger-btn {
            height: 32px; padding: 0 14px;
            background: #FEF2F2; color: #B91C1C;
            border: 1px solid #FECACA; border-radius: 8px;
            font-size: 12px; font-weight: 700; cursor: pointer; flex-shrink: 0;
            transition: all 0.12s;
        }
        .danger-btn:hover { background: #FEE2E2; border-color: #FCA5A5; }

        /* Right column */
        .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* Tab nav */
        .tab-nav {
            display: flex; gap: 2px;
            background: #F1F5F9; border-radius: 10px; padding: 4px;
            width: fit-content;
        }
        .tab-btn {
            height: 32px; padding: 0 16px; border-radius: 7px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            border: none; background: transparent; color: #64748B;
            display: flex; align-items: center; gap: 6px;
            transition: all 0.12s;
        }
        .tab-btn.active { background: #fff; color: #0F172A; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }

        /* Form sections */
        .form-body { padding: 24px; }
        .form-section { margin-bottom: 28px; }
        .form-section:last-child { margin-bottom: 0; }
        .form-section-title {
            font-size: 11px; font-weight: 700; color: #94A3B8;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .form-section-title::after { content: ''; flex: 1; height: 0.5px; background: #F1F5F9; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .form-row.single { grid-template-columns: 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label { font-size: 12px; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 5px; }
        .form-label .required { color: #DC2626; }
        .form-input {
            height: 38px; border: 1px solid #E2E8F0; border-radius: 9px;
            padding: 0 12px; font-size: 13px; color: #334155; font-weight: 600;
            background: #fff; outline: none; transition: border-color 0.12s;
        }
        .form-input:focus { border-color: #2563EB; box-shadow: 0 0 0 3px #EFF6FF; }
        .form-textarea {
            border: 1px solid #E2E8F0; border-radius: 9px;
            padding: 10px 12px; font-size: 13px; color: #334155; font-weight: 600;
            background: #fff; outline: none; resize: vertical; min-height: 88px;
            line-height: 1.5; transition: border-color 0.12s;
        }
        .form-textarea:focus { border-color: #2563EB; box-shadow: 0 0 0 3px #EFF6FF; }

        /* Form footer */
        .form-footer {
            padding: 16px 24px; border-top: 1px solid #E2E8F0; background: #fff;
            display: flex; align-items: center; justify-content: space-between;
        }
        .save-hint { font-size: 12px; color: #94A3B8; font-weight: 500; display: flex; align-items: center; gap: 6px; }
        
        .save-btn {
            height: 38px; padding: 0 22px;
            background: #2563EB; color: #fff;
            border: none; border-radius: 10px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; gap: 8px; transition: background 0.12s;
        }
        .save-btn:hover { background: #1D4ED8; }
        .cancel-btn {
            height: 38px; padding: 0 16px;
            background: #fff; color: #475569;
            border: 1px solid #E2E8F0; border-radius: 10px;
            font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.12s; text-decoration: none; display: flex; align-items: center;
        }
        .cancel-btn:hover { background: #F8FAFC; border-color: #CBD5E1; }

        /* Password section */
        .password-strength { margin-top: 6px; }
        .strength-bar { height: 4px; background: #F1F5F9; border-radius: 2px; overflow: hidden; margin-bottom: 4px; }
        .strength-fill { height: 100%; border-radius: 2px; transition: width 0.3s, background 0.3s; }
        .strength-text { font-size: 11px; font-weight: 600; }

        @media (max-width: 960px) {
            .profile-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>

    <div class="page">
        <div class="main">
            <!-- Breadcrumb -->
            <x-breadcrumbs :links="[['label' => 'Profil Saya']]" />

            <!-- Header -->
            <div class="page-header mt-6">
                <h1 class="page-title">Profil Saya</h1>
                <p class="page-subtitle">Kelola informasi pribadi, preferensi analisis, dan pengaturan akun</p>
            </div>

            <div class="profile-grid" x-data="{ tab: '{{ session('tab', 'pribadi') }}', imageUrl: null }">

                <!-- ── LEFT: Profile card ───────────────── -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <!-- Identitas -->
                    <div class="panel">
                        <div class="profile-card-body">
                            <div class="avatar-wrap">
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="avatar-large" x-show="!imageUrl" />
                                    <!-- Delete Photo Button -->
                                    <form action="{{ route('profile.photo.destroy') }}" method="POST" class="inline" x-show="!imageUrl">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="avatar-delete-btn" onclick="return confirm('Hapus foto profil?')" title="Kembalikan ke Default">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <div class="avatar-large" x-show="!imageUrl">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="avatar-large">
                                </template>
                                <!-- Edit Photo Button -->
                                <label for="photo-upload" class="avatar-edit-btn" title="Ubah Foto">
                                    <i class="ti ti-camera"></i>
                                </label>
                                <form id="photo-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                    <input type="file" id="photo-upload" name="photo" accept="image/*" @change="document.getElementById('photo-form').submit()">
                                </form>
                            </div>
                            <div class="profile-name">{{ Auth::user()->name }}</div>
                            <div class="profile-prodi">
                                <i class="ti ti-school" style="font-size:13px"></i>
                                Teknik Informatika
                            </div>
                        </div>
                    </div>

                    <!-- Zona Berbahaya -->
                    <div class="panel">
                        <div class="panel-header" style="border-bottom:none;padding-bottom:12px;">
                            <div class="panel-title" style="color:#DC2626;">Zona Berbahaya</div>
                        </div>
                        <div class="danger-zone" style="padding-top:0;">
                            <div class="mb-2">
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Hapus Akun Permanen</div>
                                <p class="text-[13px] text-slate-500 font-medium leading-relaxed mb-6">
                                    Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen dari sistem kami. Harap pastikan Anda telah mempertimbangkan keputusan ini dengan matang.
                                </p>
                                <button type="button" class="w-full h-[38px] bg-red-600 text-white text-[12px] font-bold rounded-xl hover:bg-red-700 transition-all shadow-sm shadow-red-200" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                    <i class="ti ti-trash" style="font-size:14px"></i> Hapus Akun Saya
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── RIGHT: Tabs ───────────────────────── -->
                <div class="right-col">

                    <!-- Tab nav -->
                    <div class="tab-nav">
                        <button class="tab-btn" :class="tab === 'pribadi' ? 'active' : ''" @click="tab = 'pribadi'">
                            <i class="ti ti-user" style="font-size:13px"></i> Pribadi
                        </button>
                        <button class="tab-btn" :class="tab === 'keamanan' ? 'active' : ''" @click="tab = 'keamanan'">
                            <i class="ti ti-shield-lock" style="font-size:13px"></i> Keamanan
                        </button>
                    </div>

                    <!-- ══ TAB: PRIBADI ══════════════════════ -->
                    <div x-show="tab === 'pribadi'" style="display: none;" x-transition:enter.duration.300ms>
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
                                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                                <input class="form-input" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">Email Aktif <span class="required">*</span></label>
                                                <input class="form-input" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nomor WhatsApp</label>
                                                <input class="form-input" type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="+62 812 xxxx xxxx">
                                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                            </div>
                                        </div>
                                        <div class="form-row single">
                                            <div class="form-group">
                                                <label class="form-label">Bio Singkat</label>
                                                <textarea class="form-textarea" name="bio" placeholder="Ceritakan sedikit tentang dirimu, minat, atau tujuan magang...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <div class="save-hint"><i class="ti ti-info-circle" style="font-size:14px"></i> Perubahan tersimpan otomatis</div>
                                    <div style="display:flex;gap:10px;align-items:center;">
                                        @if (session('status') === 'profile-updated')
                                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-[11px] font-bold text-green-600">Tersimpan</span>
                                        @endif
                                        <a href="{{ route('dashboard') }}" class="cancel-btn">Batal</a>
                                        <button type="submit" class="save-btn"><i class="ti ti-check" style="font-size:14px"></i> Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ══ TAB: KEAMANAN ═════════════════════ -->
                    <div x-show="tab === 'keamanan'" style="display: none;" x-transition:enter.duration.300ms>
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
                                            <div class="form-group relative">
                                                <label class="form-label">Password Saat Ini <span class="required">*</span></label>
                                                <input class="form-input w-full pr-10" :type="showCurrentPass ? 'text' : 'password'" name="current_password" required autocomplete="current-password" placeholder="Masukkan password lama">
                                                <button type="button" @click="showCurrentPass = !showCurrentPass" class="absolute right-3 top-[34px] text-slate-400 hover:text-slate-600 focus:outline-none">
                                                    <i class="ti" :class="showCurrentPass ? 'ti-eye-off' : 'ti-eye'"></i>
                                                </button>
                                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                            </div>
                                        </div>
                                    @else
                                        <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:12px 14px;font-size:12px;color:#1D4ED8;font-weight:600;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                                            <i class="ti ti-info-circle" style="font-size:16px;margin-top:2px;"></i>
                                            <div>Anda masuk menggunakan Google. Saat ini sistem membuatkan password acak untuk Anda. Silakan atur password baru di bawah ini jika Anda ingin login dengan Email.</div>
                                        </div>
                                        <input type="hidden" name="current_password" value="google_oauth_bypass_placeholder">
                                    @endif

                                    <div class="form-row">
                                        <div class="form-group relative">
                                            <label class="form-label">Password Baru <span class="required">*</span></label>
                                            <input class="form-input w-full pr-10" :type="showNewPass ? 'text' : 'password'" name="password" id="newPass" oninput="checkStrength(this.value)" required autocomplete="new-password" placeholder="Min. 8 karakter">
                                            <button type="button" @click="showNewPass = !showNewPass" class="absolute right-3 top-[34px] text-slate-400 hover:text-slate-600 focus:outline-none">
                                                <i class="ti" :class="showNewPass ? 'ti-eye-off' : 'ti-eye'"></i>
                                            </button>
                                            <div class="password-strength">
                                                <div class="strength-bar"><div class="strength-fill" id="strengthFill" style="width:0%;background:#E2E8F0;"></div></div>
                                                <span class="strength-text" id="strengthText" style="color:#94A3B8;">Belum diisi</span>
                                            </div>
                                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                        </div>
                                        <div class="form-group relative">
                                            <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                                            <input class="form-input w-full pr-10" :type="showConfPass ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
                                            <button type="button" @click="showConfPass = !showConfPass" class="absolute right-3 top-[34px] text-slate-400 hover:text-slate-600 focus:outline-none">
                                                <i class="ti" :class="showConfPass ? 'ti-eye-off' : 'ti-eye'"></i>
                                            </button>
                                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:12px 14px;font-size:12px;color:#64748B;font-weight:500;margin-top:16px;line-height:1.7;">
                                        <strong style="color:#334155;">Tips password kuat:</strong> minimal 8 karakter, kombinasi huruf besar &amp; kecil, angka, dan simbol seperti !@#$
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <div class="save-hint"><i class="ti ti-shield-check" style="font-size:14px"></i> Enkripsi aman</div>
                                    <div style="display:flex;gap:10px;align-items:center;">
                                        @if (session('status') === 'password-updated')
                                            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-[11px] font-bold text-green-600">Tersimpan</span>
                                        @endif
                                        <a href="{{ route('dashboard') }}" class="cancel-btn">Batal</a>
                                        <button type="submit" class="save-btn"><i class="ti ti-lock" style="font-size:14px"></i> Perbarui Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Akun -->
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
                    class="w-full h-11 px-4 rounded-xl border-slate-200 focus:border-red-600 focus:ring-red-600 mt-2"
                    placeholder="{{ __('Password Konfirmasi') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" class="h-10 px-6 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="h-10 px-6 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-sm shadow-red-200">
                    {{ __('Hapus Sekarang') }}
                </button>
            </div>
        </form>
    </x-modal>

    <script>
        function checkStrength(val) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            
            const levels = [
                { pct: '0%', color: '#E2E8F0', label: 'Belum diisi', labelColor: '#94A3B8' },
                { pct: '25%', color: '#DC2626', label: 'Lemah', labelColor: '#DC2626' },
                { pct: '50%', color: '#D97706', label: 'Cukup', labelColor: '#D97706' },
                { pct: '75%', color: '#2563EB', label: 'Kuat', labelColor: '#2563EB' },
                { pct: '100%', color: '#16A34A', label: 'Sangat Kuat', labelColor: '#16A34A' },
            ];
            
            const l = val.length === 0 ? levels[0] : levels[score] || levels[4];
            fill.style.width = l.pct;
            fill.style.background = l.color;
            text.textContent = l.label;
            text.style.color = l.labelColor;
        }
    </script>
</x-app-layout>
