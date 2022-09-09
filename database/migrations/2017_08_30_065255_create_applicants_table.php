<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('applicant_id');
            $table->string('first_name', 40);
            $table->string('middle_name', 30)->nullable();
            $table->string('last_name', 30);
            $table->string('suffix_name', 4)->nullable();
            $table->tinyInteger('age')->unsigned();
            $table->boolean('gender');
            $table->string('nationality', 20)->nullable();
            $table->timestamps();

            $table->index(['first_name', 'middle_name', 'last_name', 'suffix_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
