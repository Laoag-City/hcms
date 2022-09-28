<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImmunizationsRowUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immunizations', function (Blueprint $table) {
            $table->integer('health_certificate_id')->unsigned()->nullable()->change();
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
        Schema::table('immunizations', function (Blueprint $table) {
            //
        });
    }
}
