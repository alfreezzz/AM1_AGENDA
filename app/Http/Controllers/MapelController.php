<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Data_guru;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mapel = Mapel::with(['dataGurus' => function ($query) {
            $query->orderByRaw("CAST(SUBSTRING_INDEX(kode_guru, '-', 1) AS UNSIGNED), SUBSTRING_INDEX(kode_guru, '-', -1)");
        }])
            ->when($search, function ($query, $search) {
                $query->where('nama_mapel', 'like', '%' . $search . '%')
                    ->orWhereHas('dataGurus', function ($query) use ($search) {
                        $query->where('users.name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(50)  // <- paginate di sini, 10 per halaman
            ->appends(['search' => $search]); // agar query search tetap di URL saat pindah halaman

        return view('admin.mapel.index', compact('mapel'), ['title' => 'Mata Pelajaran']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_guru = Data_guru::all();
        return view('admin.mapel.create', compact('data_guru'), ['title' => 'Tambah Mata Pelajaran']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
        ]);

        $mapel = new Mapel;
        $mapel->nama_mapel = $request->nama_mapel;
        $mapel->save();

        // Cek apakah ada guru yang dipilih untuk ditambahkan, jika tidak, lewati proses attach
        if ($request->filled('data_guru_ids')) {
            $mapel->dataGurus()->attach($request->data_guru_ids);
        }

        return redirect('mapel')->with('status', 'Mapel berhasil ditambahkan');
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
        $mapel = Mapel::with('dataGurus')->findOrFail($id);
        $data_guru = Data_guru::all();
        return view('admin.mapel.edit', compact('mapel', 'data_guru'), ['title' => 'Edit Mata Pelajaran']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_mapel' => 'required',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->nama_mapel = $request->nama_mapel;
        $mapel->save();

        return redirect('mapel')->with('status', 'Mapel berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect('mapel')->with('status', 'Mapel berhasil dihapus');
    }
}
