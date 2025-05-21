<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen_siswa extends Model
{
    use HasFactory;

    protected $table = 'absen_siswas';

    // Menambahkan properti fillable untuk memungkinkan mass assignment
    protected $fillable = ['tgl', 'keterangan', 'kelas_id', 'nis_id', 'surat_sakit'];

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'kelas_id', 'id');
    }

    public function data_siswa()
    {
        return $this->belongsTo(Data_siswa::class, 'nis_id', 'id');
    }
}
