<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_attendences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('academic_years_id');
            $table->foreign('academic_years_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('teachers_id');
            $table->foreign('teachers_id')->references('id')->on('teachers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('submited_by');
            $table->foreign('submited_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->string('hour');
            $table->string('status')->default('present');
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
        Schema::dropIfExists('teacher_attendences');
    }
}
