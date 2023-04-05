<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->id();
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
            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('stream_or_combs_id');
            $table->foreign('stream_or_combs_id')->references('id')->on('stream_or_combs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->boolean('is_teacher_edit')->default(false);
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
        Schema::dropIfExists('rollcalls');
    }
}
