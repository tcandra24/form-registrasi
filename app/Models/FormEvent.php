<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEvent extends Model
{
    use HasFactory;
    public $table = 'form_event';

    protected $fillable = [
        'form_field_id',
        'event_id'
    ];
}
