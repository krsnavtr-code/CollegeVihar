<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTest extends Model
{
    protected $table = 'mock_tests';

    protected $fillable = ['test_duration', 'competitive_exam_id'];

    public function competitiveExam()
    {
        return $this->belongsTo(CompetitiveExam::class, 'competitive_exam_id');
    }

    public function questions()
    {
        return $this->hasMany(MockQuestion::class, 'mock_test_id');
    }
}