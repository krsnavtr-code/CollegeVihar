<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddUnivRegistration extends Model
{
    use HasFactory;

    protected $table = 'adduniv_registrations';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
