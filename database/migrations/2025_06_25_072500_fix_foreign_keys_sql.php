<?php

use Illuminate\Database\Migrations\Migration;
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
        
        // Add foreign key constraints using raw SQL
        DB::statement('ALTER TABLE universities 
            ADD CONSTRAINT universities_country_id_foreign 
            FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL');
            
        DB::statement('ALTER TABLE universities 
            ADD CONSTRAINT universities_state_id_foreign 
            FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL');
            
        DB::statement('ALTER TABLE universities 
            ADD CONSTRAINT universities_city_id_foreign 
            FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL');
    }

    /**
     * Drop a foreign key constraint if it exists.
     */
    protected function dropForeignIfExists($constraintName)
    {
        $result = DB::select(
            "SELECT COUNT(*) as count FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'universities' 
            AND CONSTRAINT_NAME = ? 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'", 
            [$constraintName]
        );
        
        if ($result[0]->count > 0) {
            DB::statement("ALTER TABLE universities DROP FOREIGN KEY `$constraintName`");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign key constraints
        $this->dropForeignIfExists('universities_country_id_foreign');
        $this->dropForeignIfExists('universities_state_id_foreign');
        $this->dropForeignIfExists('universities_city_id_foreign');
        
        // Revert column types if needed
        DB::statement('ALTER TABLE universities MODIFY country_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id INT NULL');
    }
};
