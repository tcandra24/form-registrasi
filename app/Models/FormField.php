<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'label',
        'type',
        'model_path',
        'multiple',
        'validation_rule',
        'validation_message',
        'relation_method_name'
    ];

    public function event()
    {
        return $this->belongsToMany(Event::class, 'form_event');
    }

    public function getLabelAttribute($value)
    {
        return ucwords($value);
    }
}
