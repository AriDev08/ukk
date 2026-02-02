<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = ['nama_jurusan', 'singkatan'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
