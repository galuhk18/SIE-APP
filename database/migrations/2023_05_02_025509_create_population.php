<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('population', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('family_card');
            $table->string('name');
            $table->string('gender');
            $table->text('address');
            $table->date('date_of_birth');
            $table->text('birth_place');
            $table->string('phone_number');
            $table->string('religion');
            $table->string('citizenship');
            $table->string('married');
            $table->string('job');
            $table->string('father_name');
            $table->string('mother_name');
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
        Schema::dropIfExists('population');
    }
}
