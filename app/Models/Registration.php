<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'no_hp',
        'vehicle_type',
        'license_plate',
        'job_id',
        'shift_id',
        'user_id',
        'token'
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
