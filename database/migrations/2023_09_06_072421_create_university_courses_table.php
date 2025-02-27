<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_courses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('university_id')->index('university');
            $table->integer('course_id')->index('course');
            $table->json('course_desc')->default('[]');
            $table->json('course_faqs')->default('[]');
            $table->text('course_commision');
            $table->integer('course_status')->default(1);
            $table->integer('course_detail_added')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('university_courses');
    }
};
