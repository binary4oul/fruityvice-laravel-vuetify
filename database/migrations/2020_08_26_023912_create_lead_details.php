<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_details', function (Blueprint $table) {
            $table->string('id');
            $table->string('leadid')->default('');
            $table->string('email')->nullable();
            $table->string('besttimetocall')->nullable();
            $table->string('hearaboutus')->nullable();
            $table->string('howcanwehelp')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('lead_details');
    }
}
