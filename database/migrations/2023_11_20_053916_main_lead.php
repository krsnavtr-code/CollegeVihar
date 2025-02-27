<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_leads', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('lead_name')->nullable();
            $table->string('getNumber')->nullable();
            $table->string('getEmail')->nullable();
            $table->string('getAddress')->nullable();
            $table->string('getCourse')->nullable();
            $table->text('getDescription')->nullable();
            $table->string('lead_types')->default('Mainsite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_leads');
    }
};
