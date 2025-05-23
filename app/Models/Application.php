<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['user_id', 'job_id', 'cv', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }  
      
    public function job()
    {
        return $this->belongsTo(Jobs::class);
    }
}
