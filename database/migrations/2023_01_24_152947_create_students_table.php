<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('parents_id');
            $table->foreign('parents_id')->references('id')->on('wazazis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('fname');
            $table->string('mname')->nullable();  
            $table->string('lname');
            $table->string('gender');
            $table->string('phone');
            $table->string('entry_status');
            $table->string('entry_date');
            $table->string('health_problem')->default('Normal');
            $table->string('physical_condition')->default('Normal');
            $table->text('physical_parts')->nullable();
            $table->string('RegNo')->unique();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('students');
    }
}
