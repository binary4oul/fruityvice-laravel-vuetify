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
            $table->string('ingredientid');
            $table->string('projectdetailid');
            $table->string('colorid')->nullable();
            $table->string('patternid')->nullable();
            $table->float('purchaseprice');
            $table->float('chargeprice');
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
