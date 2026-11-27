<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SiswaCreatePageTest extends TestCase
{
    public function test_authenticated_user_can_open_create_form(): void
    {
        $response = $this->actingAs(User::factory()->make())
            ->get(route('siswa.create'));

        $response->assertOk()
            ->assertSee('Tambah Data Siswa')
            ->assertSee('NISN')
            ->assertSee('Nama Lengkap')
            ->assertSee('Jenis Kelamin')
            ->assertSee('Kelas')
            ->assertSee('Alamat')
            ->assertSee('Simpan Data')
            ->assertSee('bg-primary bg-gradient')
            ->assertSee('input-group')
            ->assertSee('bi bi-person-plus-fill')
            ->assertSee('multipart/form-data')
            ->assertSee('Foto Profil Siswa');
    }
}
