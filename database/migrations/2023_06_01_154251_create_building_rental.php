<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingRental extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_rental', function (Blueprint $table) {
            $table->id();
            $table->string('building_code');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->text('rental_reasons');
            $table->integer('number_of_people');
            $table->string('person_responsible');
            $table->string('telp');
            $table->string('status')->comment('0:waiting_approval;1:approval;2:rejected;3:finished');
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
        Schema::dropIfExists('building_rental');
    }
}
