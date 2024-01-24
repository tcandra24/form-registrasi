<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug', 'link', 'image', 'is_active'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'event_id', 'id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_slug', 'slug');
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getImageAttribute($value)
    {
        return asset('/storage/images/events/' . $value);
    }
}
