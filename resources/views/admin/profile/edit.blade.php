<x-admin-layout>
    <style>
        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Main grid */
        .profile-grid { display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

        /* Panel */
        .panel { background: #fff; border: 0.5px solid #E2E8F0; border-radius: 16px; overflow: hidden; margin-bottom: 24px; }
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

        .profile-name { font-size: 18px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px; margin-bottom: 8px; }
        .profile-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #EFF6FF; color: #2563EB;
            border-radius: 8px; padding: 5px 12px;
            font-size: 11px; font-weight: 700; text-transform: uppercase; tracking-wider;
        }

        /* Right column */
        .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* Tab nav */
        .tab-nav {
            display: flex; gap: 4px;
            background: #F1F5F9; border-radius: 12px; padding: 4px;
            width: fit-content;
            margin-bottom: 8px;
        }
        .tab-btn {
            height: 36px; padding: 0 20px; border-radius: 9px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            border: none; background: transparent; color: #64748B;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .tab-btn.active { background: #fff; color: #2563EB; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        /* Form elements */
        .form-body { padding: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 8px; }
        .form-label .required { color: #DC2626; }
        .form-input {
            width: 100%; height: 42px; border: 1px solid #E2E8F0; border-radius: 10px;
            padding: 0 14px; font-size: 14px; color: #0F172A; font-weight: 600;
            background: #fff; outline: none; transition: all 0.2s;
        }
        .form-input:focus { border-color: #2563EB; box-shadow: 0 0 0 3px #EFF6FF; }
        
        .form-footer {
            padding: 16px 24px; border-top: 0.5px solid #F1F5F9; background: #fff;
            display: flex; align-items: center; justify-content: flex-end; gap: 12px;
        }

        .btn-primary {
            height: 42px; padding: 0 24px; background: #2563EB; color: #fff;
            border: none; border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;
        }
        .btn-primary:hover { background: #1D4ED8; transform: translateY(-1px); }
        .btn-secondary {
            height: 42px; padding: 0 24px; background: #F1F5F9; color: #475569;
            border: none; border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;
            text-decoration: none;
        }
        .btn-secondary:hover { background: #E2E8F0; color: #0F172A; }

        /* Password toggler */
        .relative { position: relative; }
        .password-toggle {
            position: absolute; right: 12px; top: 38px;
            color: #94A3B8; cursor: pointer; padding: 4px;
            transition: color 0.2s;
        }
        .password-toggle:hover { color: #64748B; }

        /* Password strength */
        .password-strength { margin-top: 8px; }
        .strength-bar { height: 4px; background: #F1F5F9; border-radius: 2px; overflow: hidden; margin-bottom: 4px; }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.3s; }
        .strength-text { font-size: 11px; font-weight: 600; }

        @media (max-width: 960px) {
            .profile-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Profil Admin</h1>
        <p class="page-subtitle">Kelola informasi akun administrator dan pengaturan keamanan</p>
    </div>

    <div class="profile-grid" x-data="{ 
        tab: '{{ session('tab', 'pribadi') }}', 
        imageUrl: null,
        showNewPass: false,
        showConfPass: false
    }">
        <!-- LEFT COLUMN: Profile Card -->
        <div>
            <div class="panel">
                <div class="profile-card-body">
                    <div class="avatar-wrap">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" class="avatar-large" x-show="!imageUrl" />
                        @else
                            <div class="avatar-large" x-show="!imageUrl">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="avatar-large">
                        </template>
                        
                        <label for="photo-upload" class="avatar-edit-btn" title="Ubah Foto">
                            <i class="ti ti-camera"></i>
                        </label>
                    </div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-badge">
                        <i class="ti ti-shield-check"></i>
                        Administrator
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Tabs -->
        <div class="right-col">
            <!-- Tab Navigation -->
            <div class="tab-nav">
                <button class="tab-btn" :class="tab === 'pribadi' ? 'active' : ''" @click="tab = 'pribadi'">
                    <i class="ti ti-user-circle"></i> Informasi Profil
                </button>
                <button class="tab-btn" :class="tab === 'keamanan' ? 'active' : ''" @click="tab = 'keamanan'">
                    <i class="ti ti-lock"></i> Keamanan
                </button>
            </div>

            <!-- TAB: PRIBADI -->
            <div x-show="tab === 'pribadi'" x-transition:enter.duration.300ms>
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Informasi Dasar</div>
                            <div class="panel-subtitle">Perbarui nama dan alamat email administrator</div>
                        </div>
                    </div>
                    
                    <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        
                        <div class="form-body">
                            <!-- Hidden File Input for Avatar (triggered by camera icon) -->
                            <input type="file" id="photo-upload" name="photo" accept="image/*" class="hidden" 
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imageUrl = e.target.result }; reader.readAsDataURL(file); }">

                            <div class="form-group">
                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Alamat Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>
                        
                        <div class="form-footer">
                            @if(session('success') && session('tab') === 'pribadi')
                                <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-[12px] font-bold text-emerald-600 mr-2">
                                    <i class="ti ti-check"></i> Tersimpan
                                </span>
                            @endif
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB: KEAMANAN -->
            <div x-show="tab === 'keamanan'" style="display: none;" x-transition:enter.duration.300ms>
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Ubah Password</div>
                            <div class="panel-subtitle">Pastikan akun menggunakan password yang kuat dan aman</div>
                        </div>
                    </div>
                    
                    <form method="post" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <!-- Keep current name/email to avoid validation errors if they are not in this form -->
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="form-body">
                            <div class="form-group relative">
                                <label class="form-label">Password Baru <span class="required">*</span></label>
                                <input :type="showNewPass ? 'text' : 'password'" name="password" class="form-input pr-10" placeholder="Minimal 8 karakter" oninput="checkStrength(this.value)" required>
                                <button type="button" @click="showNewPass = !showNewPass" class="password-toggle">
                                    <i class="ti" :class="showNewPass ? 'ti-eye-off' : 'ti-eye'"></i>
                                </button>
                                
                                <div class="password-strength">
                                    <div class="strength-bar"><div class="strength-fill" id="strengthFill" style="width:0%;background:#F1F5F9;"></div></div>
                                    <span class="strength-text" id="strengthText" style="color:#94A3B8;">Belum diisi</span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div class="form-group relative">
                                <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                                <input :type="showConfPass ? 'text' : 'password'" name="password_confirmation" class="form-input pr-10" placeholder="Ulangi password baru" required>
                                <button type="button" @click="showConfPass = !showConfPass" class="password-toggle">
                                    <i class="ti" :class="showConfPass ? 'ti-eye-off' : 'ti-eye'"></i>
                                </button>
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>

                            <div style="background:#F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 16px; margin-top: 12px;">
                                <div style="display:flex; gap:10px; align-items:flex-start;">
                                    <i class="ti ti-info-circle" style="color:#2563EB; font-size:16px; margin-top:2px;"></i>
                                    <div style="font-size:12px; color:#64748B; line-height:1.6; font-weight:500;">
                                        <strong style="color:#334155; display:block; margin-bottom:2px;">Saran Password Aman:</strong>
                                        Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan maksimal.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-footer">
                            @if(session('success') && session('tab') === 'keamanan')
                                <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-[12px] font-bold text-emerald-600 mr-2">
                                    <i class="ti ti-check"></i> Password Diperbarui
                                </span>
                            @endif
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">
                                <i class="ti ti-lock"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                { pct: '0%', color: '#F1F5F9', label: 'Belum diisi', labelColor: '#94A3B8' },
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
</x-admin-layout>
