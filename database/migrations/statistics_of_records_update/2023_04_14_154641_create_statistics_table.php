<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('statistic_id');
            $table->integer('document_category_id')->unsigned();
            $table->integer('year_id')->unsigned();
            $table->string('record_type', 25);
            $table->string('year', 4);
            $table->unsignedSmallInteger('counts');
            $table->timestamps();

            $table->foreign('document_category_id')
                                    ->references('document_category_id')
                                    ->on('document_categories')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');

            $table->foreign('year_id')
                                    ->references('year_id')
                                    ->on('years')
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
        Schema::dropIfExists('statistics');
    }
}
