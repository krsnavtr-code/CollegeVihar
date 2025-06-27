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
        Schema::table('universities', function (Blueprint $table) {
            $table->year('univ_established_year')->nullable()->after('univ_address');
            $table->string('univ_approved_by', 100)->nullable()->after('univ_established_year');
            $table->string('univ_accreditation', 50)->nullable()->after('univ_approved_by');
            $table->text('univ_programs_offered')->nullable()->after('univ_accreditation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn([
                'univ_established_year',
                'univ_approved_by',
                'univ_accreditation',
                'univ_programs_offered'
            ]);
        });
    }
};
