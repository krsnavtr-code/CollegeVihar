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
            if (!Schema::hasColumn('universities', 'univ_faqs')) {
                $table->json('univ_faqs')->nullable()->after('univ_career_guidance');
            }
            if (!Schema::hasColumn('universities', 'univ_facts')) {
                $table->json('univ_facts')->nullable()->after('univ_faqs');
            }
            if (!Schema::hasColumn('universities', 'univ_advantage')) {
                $table->json('univ_advantage')->nullable()->after('univ_facts');
            }
            if (!Schema::hasColumn('universities', 'univ_industry')) {
                $table->json('univ_industry')->nullable()->after('univ_advantage');
            }
            if (!Schema::hasColumn('universities', 'univ_carrier')) {
                $table->json('univ_carrier')->nullable()->after('univ_industry');
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
                'univ_faqs',
                'univ_facts',
                'univ_advantage',
                'univ_industry',
                'univ_carrier'
            ]);
        });
    }
};
