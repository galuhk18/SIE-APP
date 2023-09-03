<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityCompensation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_compensation', function (Blueprint $table) {
            $table->id();
            $table->string('facility_name');
            $table->integer('amount');
            $table->integer('amount_compensation');
            $table->string('person_responsible');
            $table->string('telp');
            $table->text('picture')->nullable();
            $table->string('status')->comment('0:waiting_approval;1:approval;2:rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_compensation');
    }
}
