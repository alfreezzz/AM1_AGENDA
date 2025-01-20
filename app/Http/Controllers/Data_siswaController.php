<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_siswa;
use App\Models\Kelas;

class Data_siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Base query
        $data_siswaQuery = Data_siswa::with(['kelas.jurusan']);

        // Add search conditions
        if (!empty($search)) {
            $data_siswaQuery->where(function ($query) use ($search) {
                $query->where('nama_siswa', 'like', '%' . $search . '%')
                    ->orWhereHas('kelas', function ($query) use ($search) {
                        $query->where('kelas', 'like', '%' . $search . '%')
                            ->orWhere('kelas_id', 'like', '%' . $search . '%')
                            ->orWhere('thn_ajaran', 'like', '%' . $search . '%')
                            ->orWhereHas('jurusan', function ($query) use ($search) {
                                $query->where('jurusan_id', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        $data_siswa = $data_siswaQuery->get();

        return view('admin.data_siswa.index', compact('data_siswa'), ['title' => 'Data Siswa']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_siswa = Data_siswa::all();

        // Hitung tahun ajaran berdasarkan bulan sekarang
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 7) {
            $currentAcademicYear = $currentYear . '/' . ($currentYear + 1);
        } else {
            $currentAcademicYear = ($currentYear - 1) . '/' . $currentYear;
        }

        // Ambil data kelas untuk tahun ajaran sekarang
        $kelas = Kelas::where('thn_ajaran', $currentAcademicYear)
            ->orderByRaw("FIELD(kelas, 'X', 'XI', 'XII')")
            ->orderBy('kelas_id', 'asc')
            ->get();

        return view('admin.data_siswa.create', compact('data_siswa', 'kelas'), ['title' => 'Tambah Data Siswa']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_siswa' => 'required',
                'nis_id' => 'required|min:7|max:10',
                'gender' => 'required',
                'kelas_id' => 'required',
            ],
            [
                'nama_siswa.required' => 'Nama siswa tidak boleh kosong',
                'nis_id.required' => 'NIS tidak boleh kosong',
                'nis_id.min' => 'NIS harus lebih dari 7 digit',
                'nis_id.max' => 'NIS tidak boleh lebih dari 10 digit',
                'gender.required' => 'Gender tidak boleh kosong',
                'kelas_id.required' => 'Kelas tidak boleh kosong',
            ]
        );

        $add = new Data_siswa;

        $add->nama_siswa = $request->nama_siswa;
        $add->nis_id = $request->nis_id;
        $add->gender = $request->gender;
        $add->kelas_id = $request->kelas_id;

        $add->save();
        return redirect('data_siswa')->with('status', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_siswa = Data_siswa::findOrFail($id);

        // Hitung tahun ajaran berdasarkan bulan sekarang
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 7) {
            $currentAcademicYear = $currentYear . '/' . ($currentYear + 1);
        } else {
            $currentAcademicYear = ($currentYear - 1) . '/' . $currentYear;
        }

        // Ambil data kelas untuk tahun ajaran sekarang
        $kelas = Kelas::where('thn_ajaran', $currentAcademicYear)
            ->orderByRaw("FIELD(kelas, 'X', 'XI', 'XII')")
            ->orderBy('kelas_id', 'asc')
            ->get();

        return view('admin.data_siswa.edit', compact('data_siswa', 'kelas'), ['title' => 'Edit Data Siswa']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nama_siswa' => 'required',
                'nis_id' => 'required|min:7|max:10',
                'gender' => 'required',
                'kelas_id' => 'required',
            ],
            [
                'nama_siswa.required' => 'Nama siswa tidak boleh kosong',
                'nis_id.required' => 'NIS tidak boleh kosong',
                'nis_id.min' => 'NIS minimal 7 digit',
                'nis_id.max' => 'NIS tidak boleh lebih dari 10 digit',
                'gender.required' => 'Gender tidak boleh kosong',
                'kelas_id.required' => 'Kelas tidak boleh kosong',
            ]
        );

        $data_siswa = Data_siswa::findOrFail($id);

        $data_siswa->nama_siswa = $request->nama_siswa;
        $data_siswa->nis_id = $request->nis_id;
        $data_siswa->gender = $request->gender;
        $data_siswa->kelas_id = $request->kelas_id;
        $data_siswa->save();

        return redirect('data_siswa')->with('status', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_siswa = Data_siswa::findOrFail($id);
        $data_siswa->delete();

        return redirect('data_siswa')->with('status', 'Data berhasil dihapus');
    }
}
