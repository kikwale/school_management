<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_classes', function (Blueprint $table) {
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
        Schema::dropIfExists('teacher_classes');
    }
}
