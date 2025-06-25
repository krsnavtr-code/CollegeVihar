<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Drop existing foreign keys if they exist
        $this->dropForeignIfExists('universities_country_id_foreign');
        $this->dropForeignIfExists('universities_state_id_foreign');
        $this->dropForeignIfExists('universities_city_id_foreign');
        
        // Modify columns to match referenced columns
        DB::statement('ALTER TABLE universities MODIFY country_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id BIGINT UNSIGNED NULL');
        
        // Add foreign key constraints
        Schema::table('universities', function (Blueprint $table) {
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
                
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('set null');
                
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('set null');
        });
    }

    /**
     * Drop a foreign key constraint if it exists.
     */
    protected function dropForeignIfExists($constraintName)
    {
        $schema = DB::getDoctrineSchemaManager();
        $table = $schema->listTableDetails('universities');
        
        if ($table->hasForeignKey($constraintName)) {
            Schema::table('universities', function (Blueprint $table) use ($constraintName) {
                $table->dropForeign($constraintName);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign key constraints
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
        });
        
        // Revert column types if needed
        DB::statement('ALTER TABLE universities MODIFY country_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id INT NULL');
    }
};
