<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmunizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immunizations', function (Blueprint $table) {
            $table->increments('immunization_id');
            $table->integer('health_certificate_id')->unsigned();
            $table->timestamp('date');
            $table->string('kind', 15);
            $table->timestamp('expiration_date');
            $table->tinyInteger('row_number')->unsigned();
            $table->timestamps();

            $table->foreign('health_certificate_id')
                                    ->references('health_certificate_id')
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
        Schema::dropIfExists('immunizations');
    }
}
