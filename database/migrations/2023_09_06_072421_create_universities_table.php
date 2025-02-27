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
        Schema::create('universities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('univ_name');
            $table->string('univ_url');
            $table->string('univ_logo')->nullable();
            $table->string('univ_image')->nullable()->default('university_temp.webp');
            $table->string('univ_person')->nullable();
            $table->string('univ_person_email', 100)->nullable();
            $table->string('univ_person_phone', 20)->nullable();
            $table->string('univ_commision', 30)->nullable();
            $table->string('univ_type', 100)->nullable();
            $table->string('univ_state', 100)->nullable();
            $table->string('univ_address')->nullable();
            $table->text('univ_description')->nullable();
            $table->text('univ_facts')->nullable();
            $table->json('univ_advantage')->default('[]');
            $table->json('univ_industry')->default('[]');
            $table->json('univ_carrier')->default('[]');
            $table->string('univ_slug')->nullable();
            $table->integer('univ_status')->default(1);
            $table->integer('univ_detail_added')->default(0);
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universities');
    }
};
