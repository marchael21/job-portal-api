<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();            
            $table->bigInteger('job_id')->unsigned()->index();
            $table->string('name');
            $table->string('email');
            $table->string('contact_number', 50)->nullable()->default(null);
            $table->string('cv_filename')->nullable()->default(null);
            $table->text('cv_path')->nullable()->default(null);
            $table->text('applicant_message')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('job_applications', function($table) {
           $table->foreign('job_id')->references('id')->on('jobs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
}
