<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Siswa::query()
            ->select('id', 'nisn', 'nama', 'jenis_kelamin', 'kelas', 'alamat')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Kelas',
            'Alamat',
        ];
    }
}
