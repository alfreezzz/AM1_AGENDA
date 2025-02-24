<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan nilai filter role dan pencarian username dari request
        $role = $request->query('filterRole');
        $search = $request->query('search');

        // Query pengguna dengan filter dan pencarian
        $userQuery = User::query();

        if (!empty($role)) {
            $userQuery->where('role', $role);
        }

        if (!empty($search)) {
            $userQuery->where('name', 'like', '%' . $search . '%');
        }

        $user = $userQuery->with('kelas')->get();

        // Mendapatkan data kelas dan data guru dengan pengurutan kode_guru
        $kelas = Kelas::all();

        $data_guru = User::with('mapels')->get();
        $data_guru = $data_guru->toArray();
        $data_guru = collect($data_guru);

        return view('admin.user.index', compact('user', 'kelas'), ['title' => 'Data Pengguna']);
    }

    public function create()
    {
        $user = User::all();

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

        $mapel = Mapel::all();

        return view('admin.user.create', compact('user', 'kelas', 'mapel'), ['title' => 'Tambah Pengguna']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'password' => 'required|min:6',
            'role' => 'required',
            'kelas_id' => 'nullable|exists:kelas,id|required_if:role,Sekretaris',
            'mapel_ids' => 'nullable|required_if:role,Guru|array',
            'kelas_ids' => 'nullable|required_if:role,Guru|array',
        ]);

        // Pastikan kelas_id hanya bisa diisi oleh Sekretaris
        if ($request->role !== 'Sekretaris' && $request->filled('kelas_id')) {
            return redirect()->back()->withErrors(['kelas_id' => 'Kelas hanya dapat dipilih oleh pengguna dengan peran Sekretaris.']);
        }

        $add = new User;
        $add->name = $request->name;
        $add->password = Hash::make($request->password);
        $add->role = $request->role;
        $add->kelas_id = $request->kelas_id;
        $add->kode_guru = $request->kode_guru;

        $add->save();

        if ($request->role === 'Guru') {
            $add->mapels()->sync($request->mapel_ids);
            $add->dataKelas()->sync($request->kelas_ids);
        }

        return redirect('user')->with('status', 'Pengguna berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $user = User::with('mapels')->findOrFail($id);
        $mapel = Mapel::all();

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

        return view('admin.user.edit', compact('user', 'kelas', 'mapel'), ['title' => 'Edit Pengguna']);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required',
            'kelas_id' => 'nullable|exists:kelas,id|required_if:role,Sekretaris',
            'mapel_ids' => 'nullable|required_if:role,Guru|array',
            'kelas_ids' => 'nullable|required_if:role,Guru|array',
        ]);

        // Pastikan kelas_id hanya bisa diisi oleh Sekretaris
        if ($request->role !== 'Sekretaris' && $request->filled('kelas_id')) {
            return redirect()->back()->withErrors(['kelas_id' => 'Kelas hanya dapat dipilih oleh pengguna dengan peran Sekretaris.']);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->kelas_id = $request->kelas_id;

        $user->save();

        if ($request->role === 'Guru') {
            $user->mapels()->sync($request->mapel_ids);
            $user->dataKelas()->sync($request->kelas_ids);
        }

        return redirect('user')->with('status', 'Pengguna berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('user')->with('status', 'Pengguna berhasil dihapus');
    }
}
