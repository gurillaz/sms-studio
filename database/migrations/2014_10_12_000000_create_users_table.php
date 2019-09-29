<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('personal_id')->nullable();

            $table->string('phone');
            $table->string('address');
            $table->string('position');
            $table->string('salary_type');
            $table->float('salary_amount');
            $table->string('status');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('employee_type');
            $table->string('role');


            $table->softDeletes();


            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');





            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
