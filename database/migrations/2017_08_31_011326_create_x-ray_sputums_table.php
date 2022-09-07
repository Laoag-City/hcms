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
            $table->integer('health_certificate_id')->unsigned()->nullable();
            $tablie->integer('pink_health_certificate_id')->unsigned()->nullable();
            $table->date('date');
            $table->string('kind', 20);
            $table->string('result', 20);
            $table->tinyInteger('row_number')->unsigned();
            $table->timestamps();

            $table->foreign('health_certificate_id')
                                    ->references('health_certificate_id')
                                    ->on('health_certificates')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('pink_health_certificate_id')
                                    ->references('pink_health_certificate_id')
                                    ->on('pink_health_certificates')
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
