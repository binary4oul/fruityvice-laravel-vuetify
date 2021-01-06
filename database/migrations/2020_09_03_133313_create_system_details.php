<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('system_details', function (Blueprint $table) {
        $table->string('id');
        $table->string('system_id');
        $table->string('ingredient_id');
        $table->string('extra')->nullable();
        $table->float('price')->default(0);
        $table->tinyInteger('factor')->default(1);
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
        Schema::dropIfExists('system_details');
    }
}
