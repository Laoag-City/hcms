<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXRaySputumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x-ray_sputums', function (Blueprint $table) {
            $table->increments('x-ray_sputum_id');
            $table->integer('applicant_id')->unsigned();
            $table->timestamp('date')->nullable();
            $table->string('kind', 20);
            $table->string('result', 20);
            $table->tinyInteger('row_number')->unsigned();
            $table->timestamps();

            $table->foreign('applicant_id')
                                    ->references('applicant_id')
                                    ->on('health_certificates')
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
        Schema::dropIfExists('x-ray_sputums');
    }
}
