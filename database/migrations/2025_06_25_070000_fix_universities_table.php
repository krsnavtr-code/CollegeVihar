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
        // Check if the universities table exists
        if (!Schema::hasTable('universities')) {
            return;
        }

        // Add new columns if they don't exist
        Schema::table('universities', function (Blueprint $table) {
            if (!Schema::hasColumn('universities', 'country_id')) {
                $table->unsignedBigInteger('country_id')->nullable()->after('univ_category');
            }
            if (!Schema::hasColumn('universities', 'state_id')) {
                $table->unsignedBigInteger('state_id')->nullable()->after('country_id');
            }
            if (!Schema::hasColumn('universities', 'city_id')) {
                $table->unsignedBigInteger('city_id')->nullable()->after('state_id');
            }
        });

        // Add foreign key constraints
        Schema::table('universities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            
            $table->dropColumn(['country_id', 'state_id', 'city_id']);
        });
    }
};
