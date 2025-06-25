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
        // Drop existing foreign key constraints if they exist
        Schema::table('universities', function (Blueprint $table) {
            // Drop existing foreign keys
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys('universities');
            
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('country_id', $foreignKey->getLocalColumns()) || 
                    in_array('state_id', $foreignKey->getLocalColumns()) || 
                    in_array('city_id', $foreignKey->getLocalColumns())) {
                    $table->dropForeign([$foreignKey->getLocalColumns()[0]]);
                }
            }
            
            // Modify columns to match referenced columns
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            
            // Add new foreign key constraints
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
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            
            // Revert column types if needed
            $table->integer('country_id')->nullable()->change();
            $table->integer('state_id')->nullable()->change();
            $table->integer('city_id')->nullable()->change();
        });
    }
};
