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
        Schema::table('university_courses', function (Blueprint $table) {
            $table->foreign(['university_id'], 'university')->references(['id'])->on('universities');
            $table->foreign(['course_id'], 'course')->references(['id'])->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('university_courses', function (Blueprint $table) {
            $table->dropForeign('university');
            $table->dropForeign('course');
        });
    }
};
