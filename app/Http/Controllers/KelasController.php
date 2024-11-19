<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $filterKelas = $request->get('filterKelas');
    //     $kelasQuery = Kelas::with('jurusan'); // Load the jurusan relationship
    //     $kelas = Kelas::with('jurusan')->get();

    //     if (!empty($filterKelas)) {
    //         $kelasQuery->where('kelas', $filterKelas);
    //     }

    //     $kelas = $kelasQuery->get();

    //     $jurusan = Jurusan::all();

    //     return view('admin.kelas.index', compact('kelas', 'jurusan'), ['title' => 'Data Kelas & Jurusan']);
    // }

    public function kelasByJurusan($id, Request $request)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Ambil nilai pencarian dari request
        $search = $request->input('search');

        // Query untuk data kelas
        $kelas = Kelas::where('jurusan_id', $id)
            ->with('jurusan')
            ->when($search, function ($query, $search) {
                return $query->where('thn_ajaran', 'like', '%' . $search . '%'); // Filter berdasarkan tahun ajaran
            })
            ->orderByRaw("FIELD(kelas, 'X', 'XI', 'XII')")
            ->orderBy('kelas_id', 'asc')
            ->get();

        return view('admin.kelas.index', compact('kelas', 'jurusan', 'search'))
            ->with('title', 'Data Kelas untuk Jurusan ' . $jurusan->jurusan_id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jurusanId = $request->query('jurusan');
        $jurusan = Jurusan::findOrFail($jurusanId);
        return view('admin.kelas.create', compact('jurusan'))->with('title', 'Tambah Data Kelas untuk Jurusan ' . $jurusan->jurusan_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'kelas' => 'required',
                'thn_ajaran' => 'required',
                'kelas_id' => 'required',
                'jurusan' => 'required',
            ],
            [
                'kelas.required' => 'Kelas tidak boleh kosong',
                'thn_ajaran.required' => 'Tahun ajaran tidak boleh kosong',
                'kelas_id.required' => 'No kelas tidak boleh kosong',
                'jurusan.required' => 'Jurusan tidak boleh kosong',
            ]
        );

        $add = new Kelas;
        $add->kelas = $request->kelas;
        $add->thn_ajaran = $request->thn_ajaran;
        $add->kelas_id = $request->kelas_id;
        $add->jurusan_id = $request->jurusan; // perbaiki ke jurusan_id

        $add->save();

        return redirect('jurusan/' . $add->jurusan_id . '/kelas')->with('status', 'Data berhasil ditambah');
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
        $kelas = Kelas::with('dataGuruKelas')->findOrFail($id);
        $jurusan = Jurusan::all();
        return view('admin.kelas.edit', compact('kelas', 'jurusan'),  ['title' => 'Edit Data Kelas']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kelas' => 'required',
            'thn_ajaran' => 'required',
            'kelas_id' => 'required',
        ], [
            'kelas' => 'Kelas tidak boleh kosong',
            'thn_ajaran' => 'Tahun ajaran tidak boleh kosong',
            'kelas_id' => 'No kelas tidak boleh kosong',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->kelas = $request->kelas;
        $kelas->thn_ajaran = $request->thn_ajaran;
        $kelas->kelas_id = $request->kelas_id;

        $kelas->save();

        return redirect('jurusan/' . $kelas->jurusan_id . '/kelas')->with('status', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusanId = $kelas->jurusan_id;
        $kelas->delete();

        return redirect('jurusan/' . $jurusanId . '/kelas')->with('status', 'Data berhasil dihapus');
    }
}
