<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirasiHistory extends Model
{
    protected $table = 'aspirasi_history';

    protected $fillable = [
        'aspirasi_id',
        'from_status',
        'to_status',
        'changed_by',
        'note'
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
