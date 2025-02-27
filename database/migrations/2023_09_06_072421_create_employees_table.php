<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('emp_name');
            $table->string('emp_username');
            $table->string('emp_contact')->nullable();
            $table->string('emp_email')->nullable();
            $table->string('emp_company_email')->nullable();
            $table->string('emp_password');
            $table->string('emp_address', 999)->nullable();
            $table->enum('emp_gender', ['male', 'female', 'transgender']);
            $table->date('emp_dob');
            $table->date('emp_joining_date');
            $table->integer('emp_job_role')->index('jobrole');
            $table->integer('emp_salary')->nullable();
            $table->integer('emp_state')->index('state');
            $table->integer('emp_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
