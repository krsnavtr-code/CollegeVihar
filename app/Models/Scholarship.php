<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;
    protected $table = 'scholarships';

    protected $fillable = [
        'scholarship_type',     
        'exam_urls',   
        'scholarship_info',
        'questions',
        'answers',
        'videos',
        'mock_test_questions',
        'mock_test_answers',
        'scholarship_syllabus',
    ];

    protected $casts = [
        'questions' => 'json',
        'answers' => 'json',
        'videos' => 'json',
        'mock_test_questions' => 'json',
        'mock_test_answers' => 'json',
        'exam_urls' => 'json'
    ];

}
