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
        $this->dropAllForeignKeys();
        
        // Fix column types if needed
        $this->fixColumnTypes();
        
        // Add correct foreign key constraints
        $this->addForeignKeys();
    }
    
    /**
     * Drop all foreign key constraints on the universities table.
     */
    protected function dropAllForeignKeys()
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
     * Ensure all columns have the correct data types.
     */
    protected function fixColumnTypes()
    {
        $columns = [
            'country_id' => 'BIGINT UNSIGNED NULL',
            'state_id' => 'BIGINT UNSIGNED NULL',
            'city_id' => 'BIGINT UNSIGNED NULL'
        ];
        
        foreach ($columns as $column => $type) {
            DB::statement("ALTER TABLE universities MODIFY `$column` $type");
        }
    }
    
    /**
     * Add all foreign key constraints.
     */
    protected function addForeignKeys()
    {
        // Add country_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_country_id_foreign FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL');
        
        // Add state_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_state_id_foreign FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL');
        
        // Add city_id foreign key
        DB::statement('ALTER TABLE universities ADD CONSTRAINT universities_city_id_foreign FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop all foreign key constraints
        $this->dropAllForeignKeys();
        
        // Revert column types if needed
        $columns = [
            'country_id' => 'INT NULL',
            'state_id' => 'INT NULL',
            'city_id' => 'INT NULL'
        ];
        
        foreach ($columns as $column => $type) {
            DB::statement("ALTER TABLE universities MODIFY `$column` $type");
        }
    }
};
