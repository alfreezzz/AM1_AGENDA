<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'role',
        'kelas_id',
        'kode_guru',
    ];

    protected $hidden = [
        'password',
    ];
    // App\Models\User.php

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'user_id', 'mapel_id');
    }

    public function dataKelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'user_id', 'kelas_id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'user_id');
    }

    public function absen_gurus()
    {
        return $this->hasMany(Absen_guru::class, 'user_id');
    }

    public function absensiswa__gurus()
    {
        return $this->hasMany(Absensiswa_Guru::class, 'user_id');
    }
}
