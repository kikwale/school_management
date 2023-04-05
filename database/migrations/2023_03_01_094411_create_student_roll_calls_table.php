<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRollCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_roll_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('rollcalls_id');
            $table->foreign('rollcalls_id')->references('id')->on('rollcalls')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('status')->default('present');
            $table->unsignedBigInteger('submited_by');
            $table->foreign('submited_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('student_roll_calls');
    }
}
