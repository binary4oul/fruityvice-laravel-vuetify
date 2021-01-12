<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('phones', function (Blueprint $table) {
        $table->string('id');
        $table->string('person_id');
        $table->string('number');
        $table->string('type');
        $table->boolean('primary')->default(true);
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
        Schema::dropIfExists('phones');
    }
}
