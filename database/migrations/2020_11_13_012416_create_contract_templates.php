<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contract_templates', function (Blueprint $table) {
        $table->string('id');
        $table->string('name');
        $table->string('logo');
        $table->string('notetocustomer');
        $table->string('scopeofwork');
        $table->string('commoncondition');
        $table->string('downpaymentterms');
        $table->string('note');
        $table->string('conclusion');
        $table->string('footer');
        $table->tinyInteger('status')->default('1');
        $table->tinyInteger('version')->default('0');
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
        Schema::dropIfExists('contract_templates');
    }
}
