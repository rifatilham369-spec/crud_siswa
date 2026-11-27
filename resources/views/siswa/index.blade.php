@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card app-panel shadow-lg border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary bg-gradient text-white d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 p-3 p-md-4">
                        <div>
                            <span class="app-eyebrow">Manajemen Sekolah</span>
                            <h1 class="h4 mb-1 fw-bold">
                                <i class="bi bi-people-fill me-2" aria-hidden="true"></i>
                                Daftar Data Siswa
                            </h1>
                            <p class="mb-0 small text-white-50">Kelola data siswa dengan mudah.</p>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <span class="app-count-pill">
                                <i class="bi bi-person-check me-1" aria-hidden="true"></i>{{ $siswas->total() }} siswa
                            </span>
                            <a href="{{ route('siswa.export.excel') }}" class="btn btn-success fw-semibold">
                                <i class="bi bi-file-earmark-excel me-1" aria-hidden="true"></i>
                                Export Excel
                            </a>
                            <a href="{{ route('siswa.export.pdf') }}" class="btn btn-danger fw-semibold">
                                <i class="bi bi-file-earmark-pdf me-1" aria-hidden="true"></i>
                                Export PDF
                            </a>
                            <a href="{{ route('siswa.create') }}" class="btn btn-light text-primary fw-semibold">
                                <i class="bi bi-person-plus-fill me-1" aria-hidden="true"></i>
                                Tambah Siswa
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <caption class="visually-hidden">Daftar data siswa</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">NISN</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswas as $key => $siswa)
                                        <tr>
                                            <td>{{ $siswas->firstItem() + $key }}</td>
                                            <td class="fw-semibold text-nowrap">{{ $siswa->nisn }}</td>
                                            <td class="text-center">
                                                @if ($siswa->foto)
                                                    <img src="{{ asset('storage/foto_siswa/' . $siswa->foto) }}" class="rounded-circle shadow-sm" style="width: 48px; height: 48px; object-fit: cover;" alt="Foto {{ $siswa->nama }}">
                                                @else
                                                    <span class="app-avatar-placeholder" aria-label="Tidak ada foto">
                                                        <i class="bi bi-person-fill" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="fw-semibold">{{ $siswa->nama }}</td>
                                            <td>
                                                @if ($siswa->jenis_kelamin === 'L')
                                                    <span class="badge rounded-pill text-bg-primary">
                                                        <i class="bi bi-gender-male me-1" aria-hidden="true"></i>Laki-laki
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-danger">
                                                        <i class="bi bi-gender-female me-1" aria-hidden="true"></i>Perempuan
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $siswa->kelas }}</td>
                                            <td class="app-address">{{ $siswa->alamat }}</td>
                                            <td class="text-center">
                                                <form class="d-inline-flex gap-1" action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-outline-primary btn-sm app-action-button" aria-label="Edit {{ $siswa->nama }}" title="Edit">
                                                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                                        <span class="visually-hidden">Edit</span>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm app-action-button" aria-label="Hapus {{ $siswa->nama }}" title="Hapus">
                                                        <i class="bi bi-trash3" aria-hidden="true"></i>
                                                        <span class="visually-hidden">Hapus</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="py-5 text-center">
                                                <span class="app-empty-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
                                                <p class="fw-semibold mt-3 mb-1">Belum ada data siswa</p>
                                                <p class="text-muted small mb-0">Tambahkan data siswa pertama untuk memulai.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            {{ $siswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
