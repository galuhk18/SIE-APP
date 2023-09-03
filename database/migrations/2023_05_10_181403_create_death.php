<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('death', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('family_card');
            $table->string('name');
            $table->text('address');
            $table->date('date_of_death');
            $table->string('informer');
            $table->string('informer_status');
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
        Schema::dropIfExists('death');
    }
}
