<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Drop old columns if they exist
        Schema::table('universities', function (Blueprint $table) {
            if (Schema::hasColumn('universities', 'univ_country')) {
                $table->dropColumn('univ_country');
            }
            if (Schema::hasColumn('universities', 'univ_state')) {
                $table->dropColumn('univ_state');
            }
            if (Schema::hasColumn('universities', 'univ_city')) {
                $table->dropColumn('univ_city');
            }
        });

        // Add new foreign key columns if they don't exist
        Schema::table('universities', function (Blueprint $table) {
            if (!Schema::hasColumn('universities', 'country_id')) {
                $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            }
            if (!Schema::hasColumn('universities', 'state_id')) {
                $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            }
            if (!Schema::hasColumn('universities', 'city_id')) {
                $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign keys first
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            
            $table->dropColumn(['country_id', 'state_id', 'city_id']);
            
            // Add back old columns
            $table->string('univ_country')->nullable();
            $table->string('univ_state')->nullable();
            $table->string('univ_city')->nullable();
        });
    }
};
