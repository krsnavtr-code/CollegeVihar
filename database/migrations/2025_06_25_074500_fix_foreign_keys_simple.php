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
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_country_id_foreign");
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_state_id_foreign");
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_city_id_foreign");
        
        // Modify columns to BIGINT UNSIGNED
        $this->runStatement("ALTER TABLE universities MODIFY country_id BIGINT UNSIGNED NULL");
        $this->runStatement("ALTER TABLE universities MODIFY state_id BIGINT UNSIGNED NULL");
        $this->runStatement("ALTER TABLE universities MODIFY city_id BIGINT UNSIGNED NULL");
        
        // Add foreign key constraints one by one
        $this->addForeignKey('country_id', 'countries', 'id');
        $this->addForeignKey('state_id', 'states', 'id');
        $this->addForeignKey('city_id', 'cities', 'id');
    }
    
    /**
     * Safely run a SQL statement.
     */
    protected function runStatement($sql)
    {
        try {
            DB::statement($sql);
        } catch (\Exception $e) {
            // Log the error but continue
            echo "Warning: " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Add a foreign key constraint.
     */
    protected function addForeignKey($column, $referencedTable, $referencedColumn)
    {
        $constraintName = "universities_{$column}_foreign";
        
        // Check if the column exists
        $columnExists = DB::selectOne(
            "SELECT COUNT(*) as count FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'universities' 
            AND COLUMN_NAME = ?", 
            [$column]
        );
        
        if ($columnExists && $columnExists->count > 0) {
            $this->runStatement("
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
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_country_id_foreign");
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_state_id_foreign");
        $this->runStatement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_city_id_foreign");
        
        // Revert column types
        $this->runStatement("ALTER TABLE universities MODIFY country_id INT NULL");
        $this->runStatement("ALTER TABLE universities MODIFY state_id INT NULL");
        $this->runStatement("ALTER TABLE universities MODIFY city_id INT NULL");
    }
};
