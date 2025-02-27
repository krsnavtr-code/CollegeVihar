<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequirement extends Model
{
    use HasFactory;

    protected $table = 'job_requirements';

    protected $fillable = [
        'job_title',
        'job_location',
        'openings',
        'experience',
        'education',
        'salary',
        'bonus',
        'job_info',
        'skills',
        'job_timings',
        'interview_details',
        'company_name',
        'contact_person_name',
        'phone_number',
        'email',
        'contact_person_profile',
        'organization_size',
        'job_address',
    ];
}
