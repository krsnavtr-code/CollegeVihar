<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if columns already exist
        if (!Schema::hasColumn('courses', 'course_category')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->enum('course_category', ['UG', 'PG', 'DIPLOMA', 'CERTIFICATION'])
                    ->after('course_type')
                    ->default('UG');
            });
        }

        if (!Schema::hasColumn('courses', 'course_subcategory')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->enum('course_subcategory', ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL'])
                    ->after('course_category')
                    ->default('TECHNICAL');
            });
        }

        // Add indexes if they don't exist
        Schema::table('courses', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('courses');
            
            if (!array_key_exists('courses_course_category_index', $indexes)) {
                $table->index('course_category');
            }
            
            if (!array_key_exists('courses_course_subcategory_index', $indexes)) {
                $table->index('course_subcategory');
            }
        });

        // Update any null values to defaults
        DB::table('courses')
            ->whereNull('course_category')
            ->update(['course_category' => 'UG']);
            
        DB::table('courses')
            ->whereNull('course_subcategory')
            ->update(['course_subcategory' => 'TECHNICAL']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['course_category']);
            $table->dropIndex(['course_subcategory']);
            $table->dropColumn(['course_category', 'course_subcategory']);
        });
    }
};
