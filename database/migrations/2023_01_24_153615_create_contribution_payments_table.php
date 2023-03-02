<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribution_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_contributions_id');
            $table->foreign('student_contributions_id')->references('id')->on('student_contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('terms_id');
            $table->foreign('terms_id')->references('id')->on('terms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('methode');
            $table->string('methode_name')->nullable();
            $table->string('number')->nullable();
            $table->double('amount');
            $table->date('date');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('contribution_payments');
    }
}
