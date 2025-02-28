<?php

// app/Models/Result.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['competitive_exam_id', 'total_mcqs', 'correct_answers', 'score'];

   

    public function competitiveExam()
    {
        return $this->belongsTo(CompetitiveExam::class);
    }
}