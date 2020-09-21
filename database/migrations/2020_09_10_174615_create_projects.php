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
            $table->string('leadid');
            $table->string('install')->nullable();
            $table->string('completed')->nullable();
            $table->string('addressid')->nullable();
            $table->string('projectstatus')->default('estimate');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('designconsult')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('share')->default(false);
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
