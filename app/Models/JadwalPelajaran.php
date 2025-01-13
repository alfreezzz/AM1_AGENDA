<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $fillable = [
        'id' ,
        'hari',
        'kelas_id',
        'guru_id',
        'mapel_id',
        'jam_ke',
        'thn_ajaran'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Data_guru::class);
    }
}
