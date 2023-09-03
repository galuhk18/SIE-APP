<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_report', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_activity');
            $table->string('organization_name');
            $table->string('information');
            $table->string('person_responsible');
            $table->integer('status')->comment('0:waiting_approval;1:approval;2:rejected');
            $table->text('documentation');
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
        Schema::dropIfExists('activity_report');
    }
}
