<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitiveRegister extends Model
{
    use HasFactory;

    protected $table = 'competitive_register';

    protected $fillable = ['name', 'email', 'phone'];
}
