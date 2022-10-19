<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PinkHealthCertificateRowAddition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pink_health_certificates', function (Blueprint $table) {
            $table->string('client_personal_code', 30)->unique()->after('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pink_health_certificates', function (Blueprint $table) {
            //
        });
    }
}
