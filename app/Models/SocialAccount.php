<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'provider_id',
        'provider_name'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
