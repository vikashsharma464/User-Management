<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_managements', function (Blueprint $table) {
            $table->increments('id');

            $table->string('employee_name');

            $table->string('employee_email')->unique();

            $table->string('address');

            $table->string('gender');

            $table->integer('mobile');

            $table->date('dob');

            $table->date('doj');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
