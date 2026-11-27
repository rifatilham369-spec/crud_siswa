@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card app-panel app-form-card shadow-lg border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary bg-gradient text-white p-3 p-md-4">
                        <span class="app-eyebrow">Manajemen Sekolah</span>
                        <h1 class="h4 mb-1 fw-bold">
                            <i class="bi bi-person-plus-fill me-2" aria-hidden="true"></i>
                            Tambah Data Siswa
                        </h1>
                        <p class="mb-0 small text-white-50">Lengkapi formulir berikut untuk menambahkan siswa.</p>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="nisn" class="form-label">NISN</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-card-text text-primary" aria-hidden="true"></i></span>
                                    <input id="nisn" type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN">
                                </div>
                                @error('nisn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person text-primary" aria-hidden="true"></i></span>
                                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Lengkap">
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-gender-ambiguous text-primary" aria-hidden="true"></i></span>
                                    <select id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kelas" class="form-label">Kelas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-mortarboard text-primary" aria-hidden="true"></i></span>
                                    <input id="kelas" type="text" class="form-control @error('kelas') is-invalid @enderror" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1">
                                </div>
                                @error('kelas')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text align-items-start bg-light pt-3"><i class="bi bi-geo-alt text-primary" aria-hidden="true"></i></span>
                                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto Profil Siswa</label>
                                <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" accept="image/jpeg,image/png">
                                <div class="form-text">Format JPG atau PNG, ukuran maksimal 2 MB.</div>
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 pt-2">
                                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1" aria-hidden="true"></i>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
