<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')
                  ->constrained('states')
                  ->onDelete('cascade');
            $table->string('name', 100);
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure city names are unique within a state
            $table->unique(['state_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
