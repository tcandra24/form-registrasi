<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participant extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'password',
    ];

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function registrationsMechanics()
    {
        return $this->hasMany(RegistrationMechanic::class);
    }
}
