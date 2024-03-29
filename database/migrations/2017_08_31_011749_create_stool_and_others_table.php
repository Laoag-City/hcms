<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoolAndOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stool_and_others', function (Blueprint $table) {
            $table->increments('stool_and_other_id');
            $table->integer('health_certificate_id')->unsigned();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stool_and_others');
    }
}
