<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('carbohydrates', 5, 2);
            $table->float('protein', 5, 2);
            $table->float('fat', 5, 2);
            $table->float('calories', 5, 2);
            $table->float('sugar', 5, 2);
            $table->integer('fruit_id');
            $table->timestamps();
            // $table->foreign('fruit_id')->references('id')->on('fruits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nutritions');
    }
}
