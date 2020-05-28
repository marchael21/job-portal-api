<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role_id')->unsigned()->index();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->bigInteger('employer_id')->unsigned()->index()->nullable()->default(null);
            $table->boolean('status')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('users', function($table) {
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
           $table->foreign('employer_id')->references('id')->on('users')->onDelete('restrict');
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
