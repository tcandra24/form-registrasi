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
        'participant_id',
        'event_id',
        'event_slug',
        'is_scan',
        'is_vip',
        'token',
    ];

    protected $with = ['event', 'participant'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
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
}
