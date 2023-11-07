<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fullname',
        'registration_number',
        'no_hp',
        'vehicle_type',
        'license_plate',
        'job_id',
        'shift_id',
        'user_id',
        'manufacture_id',
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

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'registration_service');
    }

    public function getFullnameAttribute($value)
    {
        return ucwords($value);
    }

    public function setFullnameAttribute($value)
    {
        $this->attributes['fullname'] = strtolower($value);
    }

    public function getVehicleTypeAttribute($value)
    {
        return ucwords($value);
    }

    public function setVehicleTypeAttribute($value)
    {
        $this->attributes['vehicle_type'] = strtolower($value);
    }
}
