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

    protected static function boot()
    {
        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

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
