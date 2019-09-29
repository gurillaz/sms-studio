<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('description')->nullable();
            $table->text('status');


            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('created_by');


            $table->softDeletes();
            $table->timestamps();


            $table->foreign('job_id')->references('id')->on('jobs');
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
        Schema::dropIfExists('events');
    }
}
