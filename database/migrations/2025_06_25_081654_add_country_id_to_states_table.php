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
        Schema::table('states', function (Blueprint $table) {
            // Add country_id column as nullable first (in case there's existing data)
            $table->unsignedBigInteger('country_id')->nullable()->after('id');
            
            // Add foreign key constraint
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['country_id']);
            
            // Then drop the column
            $table->dropColumn('country_id');
        });
    }
};
