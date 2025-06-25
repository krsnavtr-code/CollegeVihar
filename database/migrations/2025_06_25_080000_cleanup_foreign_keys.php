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
        // Drop any existing foreign key constraints
        $this->dropExistingForeignKeys();
        
        // Ensure columns have the correct data types
        $this->ensureColumnTypes();
        
        // Add foreign key constraints with proper ON DELETE and ON UPDATE rules
        $this->addForeignKeys();
        
        // Drop old columns that are no longer needed
        $this->dropOldColumns();
    }
    
    /**
     * Drop any existing foreign key constraints.
     */
    protected function dropExistingForeignKeys()
    {
        $constraints = [
            'universities_country_id_foreign',
            'universities_state_id_foreign',
            'universities_city_id_foreign'
        ];
        
        foreach ($constraints as $constraint) {
            DB::statement("ALTER TABLE universities DROP FOREIGN KEY IF EXISTS `$constraint`");
        }
    }
    
    /**
     * Ensure all columns have the correct data types.
     */
    protected function ensureColumnTypes()
    {
        // Make sure the columns exist and have the correct type
        $columns = [
            'country_id' => 'BIGINT UNSIGNED NULL',
            'state_id' => 'BIGINT UNSIGNED NULL',
            'city_id' => 'BIGINT UNSIGNED NULL'
        ];
        
        foreach ($columns as $column => $type) {
            if ($this->columnExists('universities', $column)) {
                DB::statement("ALTER TABLE universities MODIFY `$column` $type");
            } else {
                DB::statement("ALTER TABLE universities ADD `$column` $type");
            }
        }
    }
    
    /**
     * Add all foreign key constraints.
     */
    protected function addForeignKeys()
    {
        // Add country_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_country_id_foreign FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL ON UPDATE CASCADE');
        
        // Add state_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_state_id_foreign FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL ON UPDATE CASCADE');
        
        // Add city_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_city_id_foreign FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }
    
    /**
     * Drop old columns that are no longer needed.
     */
    protected function dropOldColumns()
    {
        $columns = ['univ_state', 'univ_city'];
        
        foreach ($columns as $column) {
            if ($this->columnExists('universities', $column)) {
                // Check if there are any constraints on this column
                $constraints = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = ? 
                    AND TABLE_NAME = 'universities' 
                    AND COLUMN_NAME = ?
                ", [DB::getDatabaseName(), $column]);
                
                // Drop any constraints first
                foreach ($constraints as $constraint) {
                    if (!empty($constraint->CONSTRAINT_NAME)) {
                        DB::statement("ALTER TABLE universities DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
                    }
                }
                
                // Now drop the column
                DB::statement("ALTER TABLE universities DROP COLUMN `$column`");
            }
        }
    }
    
    /**
     * Check if a column exists in a table.
     */
    protected function columnExists($table, $column)
    {
        $result = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = ? 
            AND COLUMN_NAME = ?
        ", [DB::getDatabaseName(), $table, $column]);
        
        return $result[0]->count > 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign key constraints
        $this->dropExistingForeignKeys();
        
        // Add back the old columns
        DB::statement("ALTER TABLE universities ADD COLUMN univ_state VARCHAR(100) NULL AFTER univ_person_phone");
        DB::statement("ALTER TABLE universities ADD COLUMN univ_city VARCHAR(100) NULL AFTER univ_state");
        
        // Convert the columns back to their original types if needed
        DB::statement('ALTER TABLE universities MODIFY country_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY state_id INT NULL');
        DB::statement('ALTER TABLE universities MODIFY city_id INT NULL');
    }
};
