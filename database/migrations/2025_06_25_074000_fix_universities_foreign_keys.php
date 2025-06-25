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
        $this->dropForeignKeyIfExists('universities_country_id_foreign');
        $this->dropForeignKeyIfExists('universities_state_id_foreign');
        $this->dropForeignKeyIfExists('universities_city_id_foreign');
        
        // Ensure the columns are of the correct type
        $this->modifyColumnType('country_id', 'BIGINT UNSIGNED');
        $this->modifyColumnType('state_id', 'BIGINT UNSIGNED');
        $this->modifyColumnType('city_id', 'BIGINT UNSIGNED');
        
        // Add foreign key constraints
        $this->addForeignKey('country_id', 'countries', 'id');
        $this->addForeignKey('state_id', 'states', 'id');
        $this->addForeignKey('city_id', 'cities', 'id');
    }

    /**
     * Drop a foreign key constraint if it exists.
     */
    protected function dropForeignKeyIfExists($constraintName)
    {
        $result = DB::selectOne("
            SELECT COUNT(*) as count 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'universities' 
            AND CONSTRAINT_NAME = ?
            AND CONSTRAINT_TYPE = 'FOREIGN_KEY'
        ", [$constraintName]);
        
        if ($result && $result->count > 0) {
            DB::statement("ALTER TABLE universities DROP FOREIGN KEY `$constraintName`");
        }
    }
    
    /**
     * Modify a column's type if it exists.
     */
    protected function modifyColumnType($column, $type)
    {
        $result = DB::selectOne("
            SELECT COUNT(*) as count 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'universities' 
            AND COLUMN_NAME = ?
        ", [$column]);
        
        if ($result && $result->count > 0) {
            DB::statement("ALTER TABLE universities MODIFY `$column` $type NULL");
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
            AND CONSTRAINT_TYPE = 'FOREIGN_KEY'
        ", [$constraintName]);
        
        if (!$exists || $exists->count == 0) {
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
        $this->dropForeignKeyIfExists('universities_country_id_foreign');
        $this->dropForeignKeyIfExists('universities_state_id_foreign');
        $this->dropForeignKeyIfExists('universities_city_id_foreign');
        
        // Revert column types if needed
        $this->modifyColumnType('country_id', 'INT');
        $this->modifyColumnType('state_id', 'INT');
        $this->modifyColumnType('city_id', 'INT');
    }
};
