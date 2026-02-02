<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nama_lengkap',
        'kelas_id',
        'jurusan_id',
        'no_hp',
        'alamat'
    ];

    // relasi ke user (akun login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
