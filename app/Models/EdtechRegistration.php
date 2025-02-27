<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdtechRegistration extends Model
{
    use HasFactory;

    protected $table = 'edtech_registrations';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'message',
        'experience',
        'company_name',
        'company_email',
        'company_address',
        'presently_working_as',
        'admission_target',
        'terms',
    ];


}
