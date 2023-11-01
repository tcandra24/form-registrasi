<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationService extends Model
{
    use HasFactory;
    public $table = 'registration_service';

    protected $fillable = [
        'registration_id',
        'service_id'
    ];

}
