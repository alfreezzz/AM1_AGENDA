<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensiswa_Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absensiswa__gurus';

    protected $fillable = ['tgl', 'keterangan', 'kelas_id', 'nis_id', 'mapel_id', 'added_by', 'surat_sakit'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'user_id', 'mapel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function data_siswa()
    {
        return $this->belongsTo(Data_siswa::class, 'nis_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'added_by', 'kode_guru');
    }
}
