<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCervicalSmearExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cervical_smear_examinations', function (Blueprint $table) {
            $table->increments('cervical_smear_examination_id');
            $tablie->integer('pink_health_certificate_id')->unsigned();
            $table->date('date_of_exam');
            $table->string('initial', 20);
            $table->date('date_of_next_exam');
            $table->tinyInteger('row_number')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('cervical_smear_examinations');
    }
}
