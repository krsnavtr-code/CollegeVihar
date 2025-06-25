<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {
            // First, drop the existing primary key
            $table->dropPrimary();
            
            // Add auto-incrementing id column
            $table->id()->first();
            
            // Add country_id column
            $table->foreignId('country_id')
                  ->constrained('countries')
                  ->onDelete('cascade');
                  
            // Make state_name unique per country
            $table->unique(['country_id', 'state_name']);
        });
    }

    public function down()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropUnique(['country_id', 'state_name']);
            $table->dropColumn('id');
            $table->primary('id');
        });
    }
};
