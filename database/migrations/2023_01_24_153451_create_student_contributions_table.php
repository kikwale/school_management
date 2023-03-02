<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_contributions', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('contributions_id');
            // $table->foreign('contributions_id')->references('id')->on('contributions')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('academic_years_id');
            $table->foreign('academic_years_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('darasas_id');
            $table->foreign('darasas_id')->references('id')->on('darasas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('contributions_id');
            $table->foreign('contributions_id')->references('id')->on('contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->double('amount');
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
        Schema::dropIfExists('student_contributions');
    }
}
