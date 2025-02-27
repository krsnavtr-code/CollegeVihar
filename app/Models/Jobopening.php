<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobopening extends Model
{
    use HasFactory;

    protected $table = 'job_openings';

    protected $fillable = [
		 'logo',
        'job_profile',
        'company_name',
        'company_email',
        'company_phone',
        'job_experience',
        'job_detail',
	  ];
}
