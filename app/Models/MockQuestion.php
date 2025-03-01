<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockQuestion extends Model
{
    protected $table = 'mock_questions';

    protected $fillable = ['mock_test_id', 'question', 'answer1', 'answer2', 'answer3', 'answer4', 'correct_answer'];

    public function mockTest()
    {
        return $this->belongsTo(MockTest::class, 'mock_test_id');
    }
}