<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->string('id');
            $table->string('projectid');
            $table->string('systemid');
            $table->float('areaprice');
            $table->float('area');
            $table->float('arealength');
            $table->float('areawidth');
            $table->string('name');
            $table->float('systemprice');
            $table->float('saleprice')->nullable();
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
        Schema::dropIfExists('project_details');
    }
}
