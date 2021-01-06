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
        $table->string('notetocustomer')->default('');
        $table->string('scopeofwork')->default('');
        $table->string('commoncondition')->default('');
        $table->string('downpaymentterms')->default('');
        $table->string('note')->default('');
        $table->string('conclusion')->default('');
        $table->string('footer')->default('');
        $table->string('created_by')->default('');
        $table->string('updated_by')->default('');
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
