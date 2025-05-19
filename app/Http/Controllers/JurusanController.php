<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{

    public function index()
    {
        $jurusan = Jurusan::paginate(10);
        return view('admin.jurusan.index', compact('jurusan'), ['title' => 'Data Kelas & Jurusan']);
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('admin.jurusan.create', compact('jurusan'), ['title' => 'Tambah Jurusan']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required',
        ]);

        $jurusan = new Jurusan;
        $jurusan->jurusan_id = $request->jurusan_id;
        $jurusan->slug = Str::slug($request->jurusan_id);
        $jurusan->save();

        return redirect('jurusan/' . $jurusan->slug . '/kelas')->with('status', 'Jurusan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'), ['title' => 'Edit Jurusan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jurusan_id' => 'required',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->jurusan_id = $request->jurusan_id;
        $jurusan->slug = Str::slug($request->jurusan_id);
        $jurusan->save();

        return redirect('jurusan')->with('status', 'Jurusan berhasil diupdate');
    }

    public function destroy($id)
    {
        Jurusan::destroy($id);
        return redirect('jurusan')->with('status', 'Jurusan berhasil dihapus');
    }
}
