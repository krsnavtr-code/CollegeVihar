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
        // First, drop any foreign key constraints that reference the states table
        $this->dropForeignKeysReferencing('states');
        
        // Modify the id column to be BIGINT UNSIGNED
        DB::statement('ALTER TABLE states MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        
        // Recreate the foreign key constraints after modifying the column
        $this->recreateForeignKeys();
    }

    /**
     * Drop all foreign key constraints that reference the given table.
     */
    protected function dropForeignKeysReferencing($referencedTable)
    {
        $constraints = DB::select("
            SELECT 
                TABLE_NAME,
                CONSTRAINT_NAME
            FROM 
                information_schema.KEY_COLUMN_USAGE
            WHERE 
                REFERENCED_TABLE_SCHEMA = DATABASE()
                AND REFERENCED_TABLE_NAME = ?
        ", [$referencedTable]);
        
        foreach ($constraints as $constraint) {
            DB::statement("ALTER TABLE `{$constraint->TABLE_NAME}` DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
        }
    }
    
    /**
     * Recreate foreign key constraints after modifying the column.
     */
    protected function recreateForeignKeys()
    {
        // Recreate foreign key from universities to states
        if (!DB::selectOne("SHOW KEYS FROM universities WHERE Column_name = 'state_id' AND Key_name = 'universities_state_id_foreign'")) {
            DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_state_id_foreign FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop foreign key constraints
        DB::statement('ALTER TABLE universities DROP FOREIGN KEY IF EXISTS universities_state_id_foreign');
        
        // Revert the id column back to INT
        DB::statement('ALTER TABLE states MODIFY id INT NOT NULL AUTO_INCREMENT');
        
        // Recreate the foreign key constraints with the original column type
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_state_id_foreign FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL');
    }
};
