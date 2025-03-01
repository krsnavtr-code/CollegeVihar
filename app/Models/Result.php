<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = ['user_id', 'mock_test_id', 'correct_answers', 'wrong_answers', 'score_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mockTest()
    {
        return $this->belongsTo(MockTest::class, 'mock_test_id');
    }
}