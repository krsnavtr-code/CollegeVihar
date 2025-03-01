<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('mock_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mock_test_id');
            $table->text('question');
            $table->text('answer1');
            $table->text('answer2');
            $table->text('answer3');
            $table->text('answer4');
            $table->string('correct_answer'); // "1", "2", "3", or "4" for answers
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mock_questions');
    }
}