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
