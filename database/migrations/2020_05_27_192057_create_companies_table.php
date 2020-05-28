<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->unsigned()->index();
            $table->string('name')->unique();
            $table->text('description')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('province')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('phone_number', 50)->nullable()->default(null);
            $table->string('mobile_number', 50)->nullable()->default(null);
            $table->string('company_size')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('companies', function($table) {
           $table->foreign('employer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
