<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class XRaySputumsRowUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //used raw statement since the schema class has issues with the table name and how it changes a row
        DB::statement('ALTER TABLE `x-ray_sputums` CHANGE `health_certificate_id` `health_certificate_id` INT UNSIGNED DEFAULT NULL');

        Schema::table('x-ray_sputums', function (Blueprint $table) {
            $table->integer('pink_health_certificate_id')->unsigned()->nullable()->after('health_certificate_id');

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
        Schema::table('x-ray_sputums', function (Blueprint $table) {
            //
        });
    }
}
