<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMockTestsTable extends Migration
{
    public function up()
    {
        Schema::create('mock_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('test_duration');
            $table->unsignedBigInteger('competitive_exam_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('competitive_exam_id')->references('id')->on('competitive_exams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mock_tests');
    }
}