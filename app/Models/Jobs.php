<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = 't_jobs';
    protected $fillable = [
        'id','user_id','title', 'description', 'status'
    ];

    public function jobsStatusActive($query) {
        return $query->where('status', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
