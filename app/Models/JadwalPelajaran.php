<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPelajaran extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_pelajarans';

    protected $fillable = [
        'id',
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
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
