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
        $table->string('logo')->nullable();
        $table->string('notetocustomer')->nullable();
        $table->string('scopeofwork')->nullable();
        $table->string('commoncondition')->nullable();
        $table->string('downpaymentterms')->nullable();
        $table->string('note')->nullable();
        $table->string('conclusion')->nullable();
        $table->string('footer')->nullable();
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
