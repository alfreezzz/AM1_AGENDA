<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user(); // untuk salam selamat datang

        $totalJurusan = Jurusan::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();
        $totalUser = User::count();

        return view('admin.index', [
            'title' => 'Selamat Datang Kembali, ' . $currentUser->name . '!',
            'totalJurusan' => $totalJurusan,
            'totalKelas' => $totalKelas,
            'totalMapel' => $totalMapel,
            'totalUser' => $totalUser
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
