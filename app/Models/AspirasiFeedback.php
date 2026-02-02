<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirasiFeedback extends Model
{
    protected $table = 'aspirasi_feedback';

    protected $fillable = [
        'aspirasi_id',
        'admin_id',
        'feedback_text'
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
