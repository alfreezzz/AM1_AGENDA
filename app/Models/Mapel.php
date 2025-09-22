<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mapels';

    public function dataGurus()
    {
        return $this->belongsToMany(User::class, 'guru_mapel', 'mapel_id', 'user_id');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalPelajaran::class, 'mapel_id');
    }
}
