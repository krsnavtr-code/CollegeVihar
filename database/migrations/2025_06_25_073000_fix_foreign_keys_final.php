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
        // First, drop any existing foreign key constraints
        $this->dropExistingForeignKeys();
        
        // Modify columns to match the referenced columns' types
        DB::statement('ALTER TABLE universities MODIFY country_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id BIGINT UNSIGNED NULL');
        
        // Now add the foreign key constraints
        $this->addForeignKey('country_id', 'countries', 'id');
        $this->addForeignKey('state_id', 'states', 'id');
        $this->addForeignKey('city_id', 'cities', 'id');
    }

    /**
     * Drop any existing foreign key constraints on the universities table.
     */
    protected function dropExistingForeignKeys()
    {
        $foreignKeys = [
            'universities_country_id_foreign',
            'universities_state_id_foreign',
            'universities_city_id_foreign'
        ];
        
        foreach ($foreignKeys as $constraint) {
            DB::statement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS `$constraint`");
        }
    }
    
    /**
     * Add a foreign key constraint if it doesn't already exist.
     */
    protected function addForeignKey($column, $referencedTable, $referencedColumn)
    {
        $constraintName = "universities_{$column}_foreign";
        
        // Check if the foreign key already exists
        $exists = DB::selectOne("
            SELECT COUNT(*) as count 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'universities' 
            AND CONSTRAINT_NAME = ?
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$constraintName]);
        
        if ($exists && $exists->count == 0) {
            DB::statement("
                ALTER TABLE universities 
                ADD CONSTRAINT `$constraintName` 
                FOREIGN KEY (`$column`) 
                REFERENCES `$referencedTable`(`$referencedColumn`) 
                ON DELETE SET NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign key constraints
        $this->dropExistingForeignKeys();
        
        // Revert column types if needed
        DB::statement('ALTER TABLE universities MODIFY country_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id INT NULL');
    }
};
