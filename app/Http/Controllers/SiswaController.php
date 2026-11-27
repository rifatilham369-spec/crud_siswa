<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::latest()->paginate(10);

        return view('siswa.index', compact('siswas'));
    }

    public function exportExcel(): BinaryFileResponse
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }

    public function exportPdf(): Response
    {
        $siswas = Siswa::query()->orderBy('id')->get();

        return Pdf::loadView('siswa.pdf', compact('siswas'))
            ->download('data_siswa.pdf');
    }

    public function create(): View
    {
        return view('siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'max:255', Rule::unique('siswas', 'nisn')],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'kelas' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $foto = $request->file('foto');
        if ($foto instanceof UploadedFile) {
            $validated['foto'] = $this->storeStudentPhoto($foto);
        }

        Siswa::create($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa): View
    {
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'max:255', Rule::unique('siswas', 'nisn')->ignore($siswa)],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'kelas' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $oldPhoto = $siswa->foto;
        $foto = $request->file('foto');
        if ($foto instanceof UploadedFile) {
            $validated['foto'] = $this->storeStudentPhoto($foto);
        }

        $siswa->update($validated);
        if ($foto instanceof UploadedFile && $oldPhoto !== $siswa->foto) {
            $this->deleteStudentPhoto($oldPhoto);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $this->deleteStudentPhoto($siswa->foto);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    private function storeStudentPhoto(UploadedFile $foto): string
    {
        $filename = $foto->hashName();
        $storedPath = $foto->storeAs('foto_siswa', $filename, 'public');

        if ($storedPath === false) {
            throw new RuntimeException('Foto siswa gagal disimpan.');
        }

        return $filename;
    }

    private function deleteStudentPhoto(?string $filename): void
    {
        if ($filename === null || $filename === '') {
            return;
        }

        $path = 'foto_siswa/'.basename($filename);
        $disk = Storage::disk('public');

        if ($disk->exists($path) && ! $disk->delete($path)) {
            throw new RuntimeException('Foto siswa gagal dihapus.');
        }
    }
}
