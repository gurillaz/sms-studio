<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->text('description')->nullable();
            $table->smallInteger('price');
            $table->string('payment_status');

            $table->string('status');

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('created_by');



            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('offer_id')->references('id')->on('offers');
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
        Schema::dropIfExists('jobs');
    }
}
