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
        Schema::table('universities', function (Blueprint $table) {
            if (!Schema::hasColumn('universities', 'univ_scholarship')) {
                $table->json('univ_scholarship')->nullable()->after('univ_top_recruiters');
            }
            if (!Schema::hasColumn('universities', 'univ_facilities')) {
                $table->json('univ_facilities')->nullable()->after('univ_scholarship');
            }
            if (!Schema::hasColumn('universities', 'univ_gallery')) {
                $table->json('univ_gallery')->nullable()->after('univ_facilities');
            }
            if (!Schema::hasColumn('universities', 'univ_career_guidance')) {
                $table->json('univ_career_guidance')->nullable()->after('univ_gallery');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn([
                'univ_scholarship',
                'univ_facilities',
                'univ_gallery',
                'univ_career_guidance'
            ]);
        });
    }
};
