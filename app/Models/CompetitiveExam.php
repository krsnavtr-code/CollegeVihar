<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitiveExam extends Model
{
    use HasFactory;
    protected $table = 'competitive_exams';


    protected $fillable = [
        'exam_type',     
        'exam_urls',   
        'exam_opening_date',
        'exam_closing_date',
        'exam_info',
        'questions',
        'answers',
        'videos',
        'mock_test_questions',
        'mock_test_answers',
        'exam_syllabus',
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

