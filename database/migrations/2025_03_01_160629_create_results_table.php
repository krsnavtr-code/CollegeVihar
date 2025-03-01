<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming user authentication (foreign key to users table)
            $table->unsignedBigInteger('mock_test_id'); // Link to mock_test table
            $table->integer('correct_answers'); // Number of correct answers
            $table->integer('wrong_answers'); // Number of wrong answers
            $table->decimal('score_percentage', 5, 2); // Score as percentage (e.g., 85.50)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}