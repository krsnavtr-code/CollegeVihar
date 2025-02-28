<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQTest extends Model
{
    use HasFactory;

    protected $table = 'mcq_tests'; 

    protected $fillable = [
        'test_duration',
        'question',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer',
        'competitive_exam_id',
    ];

    public function competitiveExam()
    {
        return $this->belongsTo(CompetitiveExam::class, 'competitive_exam_id');
    }
}
