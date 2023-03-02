<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('darasas_id');
            $table->foreign('darasas_id')->references('id')->on('darasas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('teachers_id');
            $table->foreign('teachers_id')->references('id')->on('teachers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('stream_or_combs_id');
            $table->foreign('stream_or_combs_id')->references('id')->on('stream_or_combs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('status')->default('Core');
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
        Schema::dropIfExists('class_subjects');
    }
}
