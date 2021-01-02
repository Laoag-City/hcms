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
            $table->integer('applicant_id')->unsigned();
            $table->string('establishment_type');
            $table->string('address');
            $table->string('sanitary_permit_number', 11)->unique();
            $table->timestamp('issuance_date')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->string('sanitary_inspector');
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
        Schema::dropIfExists('sanitary_permits');
    }
}
