<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decision', function (Blueprint $table) {
            $table->id();
            $table->string('decision');
            $table->string('type_of_decision');
            $table->date('decision_date');
            $table->text('problem');
            $table->text('documentasion')->nullable();
            $table->date('realization_date');
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
        Schema::dropIfExists('decision');
    }
}
