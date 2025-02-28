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
            $table->unsignedBigInteger('competitive_exam_id');
            $table->integer('total_mcqs');
            $table->integer('correct_answers');
            $table->decimal('score', 5, 2);
            $table->timestamps();

            $table->foreign('competitive_exam_id')->references('id')->on('competitive_exams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}