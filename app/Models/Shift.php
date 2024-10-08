<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'quota',
        'event_id',
        'is_active'
    ];

    public function registration()
    {
        return $this->hasMany(Registration::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
