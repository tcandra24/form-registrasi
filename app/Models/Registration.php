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
        'participant_id',
        'event_id',
        'manufacture_id',
        'event_slug',
        'is_scan',
        'is_vip',
        'token'
    ];

    protected $with = ['shift', 'job', 'manufacture', 'services'];

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

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'registration_service');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getFullnameAttribute($value)
    {
        return ucwords($value);
    }

    public function getIsScanAttribute($value)
    {
        return $value ? 'Sudah Scan' : 'Belum Scan';
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
