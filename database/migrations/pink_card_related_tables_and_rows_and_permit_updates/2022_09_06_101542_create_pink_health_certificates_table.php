<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinkHealthCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this file's filename timestamp has been changed to precede the earlier migration files that references to its primary key
        Schema::create('pink_health_certificates', function (Blueprint $table) {
            $table->increments('pink_health_certificate_id');
            $table->integer('applicant_id')->unsigned();
            $table->string('registration_number', 11)->unique();
            $table->string('validity_period', 20); //added this row if ever pink card will have differing validity period in the future
            $table->string('occupation', 40);
            $table->string('place_of_work', 50);
            $table->date('issuance_date');
            $table->date('expiration_date');
            $table->string('community_tax_no', 20);
            $table->string('community_tax_issued_at', 30);
            $table->date('community_tax_issued_on');
            $table->boolean('is_expired');
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
        Schema::dropIfExists('pink_health_certificates');
    }
}
