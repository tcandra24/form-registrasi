<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationMechanic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fullname',
        'registration_number',
        'no_hp',
        'workshop_name',
        'address',
        'user_id',
        'event_slug',
        'is_scan',
        'is_vip',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullnameAttribute($value)
    {
        return ucwords($value);
    }

    public function setFullnameAttribute($value)
    {
        $this->attributes['fullname'] = strtolower($value);
    }
}
