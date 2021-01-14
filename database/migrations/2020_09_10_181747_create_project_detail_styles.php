<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDetailStyles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('project_detail_styles', function (Blueprint $table) {
        $table->string('id');
        $table->string('ingredient_id');
        $table->string('project_detail_id');
        $table->string('color_id')->nullable();
        $table->string('pattern_id')->nullable();
        $table->float('purchaseprice')->nullable();
        $table->float('chargeprice')->nullable();
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
        Schema::dropIfExists('project_detail_styles');
    }
}
