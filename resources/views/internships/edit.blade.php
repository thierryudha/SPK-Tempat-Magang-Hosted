<x-app-layout>
    <style>
        .page { background: #F8FAFC; min-height: 100vh; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        .main { padding: 32px 32px; max-width: 1200px; margin: 0 auto; }

        /* Typography & Header */
        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #0F172A; letter-spacing: -0.5px; margin-bottom: 4px; }
        .page-subtitle { font-size: 14px; color: #64748B; font-weight: 500; }

        /* Panels */
        .panel {
            background: #fff;
            border: 0.5px solid #E2E8F0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
            max-width: 800px;
        }
        .panel-header {
            padding: 20px 24px;
            border-bottom: 0.5px solid #F1F5F9;
        }
        .panel-title { font-size: 15px; font-weight: 700; color: #0F172A; }

        /* Forms */
        .form-group { margin-bottom: 20px; padding: 0 24px; }
        .form-group:first-of-type { margin-top: 24px; }
        .form-group:last-of-type { margin-bottom: 24px; }
        
        .label { display: block; font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
        .input {
            width: 100%; height: 44px; padding: 0 16px; border-radius: 10px; border: 1.5px solid #E2E8F0;
            background: #F8FAFC; font-size: 14px; font-weight: 600; color: #0F172A; transition: all 0.2s;
        }
        .input:focus { border-color: #2563EB; background: #fff; outline: none; box-shadow: 0 0 0 4px #EFF6FF; }

        /* Buttons */
        .btn {
            height: 42px; padding: 0 24px; border-radius: 10px; font-size: 13px; font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; border: none;
        }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-secondary { background: #F1F5F9; color: #334155; }
        .btn-secondary:hover { background: #E2E8F0; }
    </style>

    <div class="page">
        <div class="main">
            <!-- Breadcrumbs Fixed -->
            <x-breadcrumbs :links="[
                ['label' => 'Daftar Tempat Magang', 'url' => route('internships.index')],
                ['label' => 'Edit Perusahaan']
            ]" />

            <div class="page-header mt-6">
                <h1 class="page-title">Edit Tempat Magang</h1>
                <p class="page-subtitle">Perbarui informasi perusahaan "{{ $internship->name }}"</p>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Informasi Perusahaan</div>
                </div>
                <form action="{{ route('internships.update', $internship) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label class="label">Nama Perusahaan / Instansi</label>
                        <input type="text" name="name" class="input" required value="{{ old('name', $internship->name) }}">
                        @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="label">Kategori / Bidang</label>
                        <select name="category_id" class="input" required style="appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' fill=\'none\' stroke=\'%2394A3B8\' stroke-width=\'2\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'m6 9 6 6 6-6\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $internship->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label class="label">Link Website</label>
                        <input type="url" name="website_link" class="input" placeholder="https://perusahaan.com" value="{{ old('website_link', $internship->website_link) }}">
                        @error('website_link') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="px-6 pb-8 pt-4 flex gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('internships.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
