<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->text('description')->nullable();
            $table->text('payment_sum');

            $table->string('status');
            $table->tinyInteger('rating')->default(0);

            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('created_by');


            $table->softDeletes();
            $table->timestamps();


            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
