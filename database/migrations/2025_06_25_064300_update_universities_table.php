<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            // Drop the existing columns
            $table->dropColumn(['univ_state', 'univ_country', 'univ_city']);
            
            // Add new foreign key columns
            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained('countries')
                  ->onDelete('set null');
                  
            $table->foreignId('state_id')
                  ->nullable()
                  ->constrained('states')
                  ->onDelete('set null');
                  
            $table->foreignId('city_id')
                  ->nullable()
                  ->constrained('cities')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            
            $table->dropColumn(['country_id', 'state_id', 'city_id']);
            
            // Re-add the old columns
            $table->integer('univ_state')->nullable();
            $table->string('univ_country', 100)->nullable();
            $table->string('univ_city', 100)->nullable();
        });
    }
};
