<?php

namespace Tests\Feature;

use App\Exports\SiswaExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SiswaRouteTest extends TestCase
{
    public function test_guests_are_redirected_to_login_when_accessing_siswa_list(): void
    {
        $this->get('/siswa')->assertRedirectToRoute('login');
    }

    public function test_guests_are_redirected_to_login_when_accessing_student_exports(): void
    {
        $this->get(route('siswa.export.excel'))->assertRedirectToRoute('login');
        $this->get(route('siswa.export.pdf'))->assertRedirectToRoute('login');
    }

    public function test_authenticated_users_can_download_excel_export(): void
    {
        Excel::fake();

        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->id = 1;

        $this->actingAs($user)
            ->get(route('siswa.export.excel'))
            ->assertOk();

        Excel::assertDownloaded(
            'data_siswa.xlsx',
            fn ($export): bool => $export instanceof SiswaExport,
        );
    }

    public function test_authenticated_users_are_redirected_to_siswa_list_from_home_page(): void
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->id = 1;

        $this->actingAs($user)
            ->get('/')
            ->assertRedirectToRoute('siswa.index');
    }
}
