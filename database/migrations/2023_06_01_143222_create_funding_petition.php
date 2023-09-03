<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundingPetition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_petition', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_activity');
            $table->string('organization_name');
            $table->bigInteger('budget_amount');
            $table->string('event_name');
            $table->string('person_responsible');
            $table->text('proposal')->comment('pdf');
            $table->integer('status')->comment('0:waiting_approval;1:approval;2:rejected');
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
        Schema::dropIfExists('funding_petition');
    }
}
