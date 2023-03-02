<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('wazazis_id');
            $table->foreign('wazazis_id')->references('id')->on('wazazis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('relation');
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
        Schema::dropIfExists('students_parents');
    }
}
