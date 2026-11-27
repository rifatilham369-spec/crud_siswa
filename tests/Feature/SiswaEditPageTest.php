<?php

namespace Tests\Feature;

use App\Models\Siswa;
use Tests\TestCase;

class SiswaEditPageTest extends TestCase
{
    public function test_edit_view_shows_current_student_data_and_put_method(): void
    {
        $siswa = new Siswa([
            'nisn' => '1234567890',
            'nama' => 'Alya Putri',
            'jenis_kelamin' => 'P',
            'kelas' => 'X IPA 1',
            'alamat' => 'Jl. Merdeka',
        ]);
        $siswa->id = 1;

        $view = $this->withViewErrors([])
            ->view('siswa.edit', ['siswa' => $siswa]);

        $view->assertSee('Edit Data Siswa')
            ->assertSee($siswa->nisn)
            ->assertSee($siswa->nama)
            ->assertSee('Perempuan')
            ->assertSee('PUT')
            ->assertSee('Perbarui Data')
            ->assertSee('bg-primary bg-gradient')
            ->assertSee('input-group')
            ->assertSee('bi bi-pencil-square')
            ->assertSee('multipart/form-data')
            ->assertSee('Foto Profil Siswa');
    }
}
