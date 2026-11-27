<?php

namespace Tests\Feature;

use App\Models\Siswa;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class SiswaIndexPageTest extends TestCase
{
    public function test_index_view_renders_student_data_and_bootstrap_pagination(): void
    {
        $siswa = new Siswa([
            'nisn' => '1234567890',
            'nama' => 'Alya Putri',
            'jenis_kelamin' => 'P',
            'kelas' => 'X IPA 1',
            'alamat' => 'Jl. Merdeka',
        ]);
        $siswa->id = 1;
        $siswas = new LengthAwarePaginator(
            [$siswa],
            11,
            10,
            1,
            ['path' => route('siswa.index')],
        );

        $view = $this->view('siswa.index', ['siswas' => $siswas]);

        $view
            ->assertSee('Daftar Data Siswa')
            ->assertSee($siswa->nisn)
            ->assertSee($siswa->nama)
            ->assertSee('Foto')
            ->assertSee(route('siswa.export.excel'))
            ->assertSee(route('siswa.export.pdf'))
            ->assertSee('Tidak ada foto')
            ->assertSee('page-item')
            ->assertSee('shadow-lg')
            ->assertSee('bg-primary bg-gradient')
            ->assertSee('badge rounded-pill text-bg-danger')
            ->assertSee('bi bi-pencil-square')
            ->assertSee('bi bi-trash3');
    }

    public function test_index_view_displays_uploaded_student_photo(): void
    {
        $siswa = new Siswa([
            'nisn' => '0987654321',
            'nama' => 'Bima Putra',
            'jenis_kelamin' => 'L',
            'kelas' => 'XI IPA 2',
            'alamat' => 'Jl. Merdeka',
            'foto' => 'bima.jpg',
        ]);
        $siswa->id = 2;
        $siswas = new LengthAwarePaginator(
            [$siswa],
            1,
            10,
            1,
            ['path' => route('siswa.index')],
        );

        $view = $this->view('siswa.index', ['siswas' => $siswas]);

        $view->assertSee('storage/foto_siswa/bima.jpg');
    }
}
