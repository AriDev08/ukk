<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $fillable = [
        'user_id',
        'location',
        'category_id',
        'title',
        'description',
        'attachment_path',
        'status'
    ];

    // relasi ke user (siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // relasi ke feedback admin
    public function feedbacks()
    {
        return $this->hasMany(AspirasiFeedback::class);
    }

    // relasi ke histori status
    public function histories()
    {
        return $this->hasMany(AspirasiHistory::class);
    }
}
