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
        Schema::create('emp', function (Blueprint $table) {
            $table->id();
            $table->string('EmpName');
            $table->string('HireDate');
            $table->decimal('Age',4,2);
            $table->string('Gender');
            $table->string('Salary');
            $table->integer('EmpDepId');
            $table->integer('ManagerId');
            $table->integer('EmpStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_emp');
    }
};
