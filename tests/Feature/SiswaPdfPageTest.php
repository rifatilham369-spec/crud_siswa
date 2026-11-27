<?php

namespace Tests\Feature;

use App\Models\Siswa;
use Tests\TestCase;

class SiswaPdfPageTest extends TestCase
{
    public function test_pdf_view_renders_student_report_data(): void
    {
        $siswa = new Siswa([
            'nisn' => '1234567890',
            'nama' => 'Alya Putri',
            'jenis_kelamin' => 'P',
            'kelas' => 'X IPA 1',
            'alamat' => 'Jl. Merdeka',
        ]);
        $siswas = collect([$siswa]);

        $this->view('siswa.pdf', compact('siswas'))
            ->assertSee('Laporan Data Siswa')
            ->assertSee($siswa->nisn)
            ->assertSee($siswa->nama)
            ->assertSee($siswa->jenis_kelamin)
            ->assertSee($siswa->kelas)
            ->assertSee($siswa->alamat);
    }
}
