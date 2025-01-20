<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = ['kelas', 'thn_ajaran', 'kelas_id', 'jurusan_id', 'slug'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function dataGuruKelas()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Pastikan relasi jurusan dimuat
            if (!$model->relationLoaded('jurusan')) {
                $model->load('jurusan');
            }

            // Ambil nama jurusan
            $jurusanName = $model->jurusan ? $model->jurusan->jurusan_id : 'unknown';

            // Buat slug menggunakan nama jurusan
            $model->slug = Str::slug("{$model->kelas}-{$jurusanName}-{$model->kelas_id}-{$model->thn_ajaran}");
        });
    }
}
