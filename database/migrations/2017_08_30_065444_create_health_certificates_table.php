<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_certificates', function (Blueprint $table) {
            $table->increments('health_certificate_id');
            $table->integer('applicant_id')->unsigned();
            $table->string('registration_number', 10)->unique();
            $table->string('work_type', 40);
            $table->string('establishment', 50);
            $table->timestamp('issuance_date');
            $table->timestamp('expiration_date');
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('applicant_id')
                                    ->references('applicant_id')
                                    ->on('applicants')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_certificates');
    }
}
