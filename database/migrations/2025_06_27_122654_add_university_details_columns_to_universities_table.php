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
            if (!Schema::hasColumn('universities', 'univ_campus_area')) {
                $table->json('univ_campus_area')->nullable()->after('univ_description');
            }
            if (!Schema::hasColumn('universities', 'univ_student_strength')) {
                $table->json('univ_student_strength')->nullable()->after('univ_campus_area');
            }
            if (!Schema::hasColumn('universities', 'univ_faculty_strength')) {
                $table->json('univ_faculty_strength')->nullable()->after('univ_student_strength');
            }
            if (!Schema::hasColumn('universities', 'univ_highlights')) {
                $table->json('univ_highlights')->nullable()->after('univ_faculty_strength');
            }
            if (!Schema::hasColumn('universities', 'univ_admission')) {
                $table->json('univ_admission')->nullable()->after('univ_highlights');
            }
            if (!Schema::hasColumn('universities', 'univ_important_dates')) {
                $table->json('univ_important_dates')->nullable()->after('univ_admission');
            }
            if (!Schema::hasColumn('universities', 'univ_placement')) {
                $table->json('univ_placement')->nullable()->after('univ_important_dates');
            }
            if (!Schema::hasColumn('universities', 'univ_top_recruiters')) {
                $table->json('univ_top_recruiters')->nullable()->after('univ_placement');
            }
            if (!Schema::hasColumn('universities', 'univ_why_this_university')) {
                $table->json('univ_why_this_university')->nullable()->after('univ_top_recruiters');
            }
            if (!Schema::hasColumn('universities', 'univ_detail_added')) {
                $table->boolean('univ_detail_added')->default(0)->after('univ_carrier');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't drop columns in the down method to prevent data loss
        // If you need to rollback, create a new migration to drop specific columns
    }
};
