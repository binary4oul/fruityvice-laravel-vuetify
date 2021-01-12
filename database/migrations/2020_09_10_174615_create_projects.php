<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('projects', function (Blueprint $table) {
        $table->string('id');
        $table->string('email')->nullable();
        $table->string('besttimetocall')->nullable();
        $table->string('hearaboutus')->nullable();
        $table->string('howcanwehelp')->nullable();
        $table->string('install')->nullable();
        $table->string('completed')->nullable();
        $table->string('projectstatus')->default('estimate');
        $table->string('designconsult')->nullable();
        $table->boolean('active')->default(true);
        $table->boolean('share')->default(false);
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
        Schema::dropIfExists('projects');
    }
}
