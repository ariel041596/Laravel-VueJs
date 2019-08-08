<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('article');
            $table->string('description');
            $table->string('property_number');
            $table->string('unit_of_measure');
            $table->decimal('price');
            $table->decimal('quantity');
            $table->decimal('total_value');
            $table->date('date');
            $table->string('accountable_officer');
            $table->string('remarks');
            $table->string('account_name');
            $table->string('service');
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
        Schema::dropIfExists('assets');
    }
}
