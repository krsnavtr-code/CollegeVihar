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
        Schema::create('metadata', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('url_slug');
            $table->string('meta_title');
            $table->string('meta_h1', 999);
            $table->string('meta_description', 999);
            $table->string('meta_keywords', 999);
            $table->string('meta_image')->nullable();
            $table->string('meta_canonical');
            $table->text('other_meta_tags')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata');
    }
};
