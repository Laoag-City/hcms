<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanitaryPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_permits', function (Blueprint $table) {
            $table->increments('sanitary_permit_id');
            $table->integer('applicant_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->string('establishment_type');
            $table->smallInteger('total_employees')->unsigned()->nullable();
            $table->string('brgy', 40)->nullable();
            $table->string('address');
            $table->string('sanitary_permit_number', 11)->unique();
            $table->date('issuance_date');
            $table->date('expiration_date');
            $table->string('sanitary_inspector');
            $table->boolean('is_expired');
            $table->timestamps();

            $table->foreign('applicant_id')
                                    ->references('applicant_id')
                                    ->on('applicants')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('business_id')
                                    ->references('business_id')
                                    ->on('businesses')
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
        Schema::dropIfExists('sanitary_permits');
    }
}
