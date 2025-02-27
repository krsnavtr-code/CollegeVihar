<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'email_verifications';

    protected $fillable = [
        'email',
        'otp',
        'created_at'
    ];
}
