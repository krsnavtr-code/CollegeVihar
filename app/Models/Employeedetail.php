<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeedetail extends Model
{
    use HasFactory;
    
    protected $table = 'employee_details';

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'education',
        'employee_photo',
        'annual_salary',
        'employed',
        'company_name',
        'job_title',
        'current_city',
        'key_skills',
        'phone_number',
        'resume_path',
        'work_experience_years',
        'work_experience_months',
        'employment_type',
    ];

}
