<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipRegister extends Model
{
    use HasFactory;

    protected $table = 'scholarship_register';

    protected $fillable = ['name', 'email', 'phone'];
}
