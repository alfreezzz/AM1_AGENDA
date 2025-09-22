<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data_guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_gurus';

    protected $fillable = ['nama_guru', 'kode_guru', 'gender'];

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'data_guru_id', 'mapel_id');
    }
}
