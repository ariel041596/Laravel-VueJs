<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIIRUPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_i_r_u_ps', function (Blueprint $table) {
            $table->increments('id'); //1
            $table->string('number'); //2
            $table->string('article'); //3
            $table->string('description', 1000); //4
            $table->string('property_number')->nullable(); //5
            $table->string('unit_of_measure'); //6
            $table->decimal('price', 12, 2)->nullable(); //7
            $table->decimal('quantity', 12, 2); //8
            $table->decimal('total_value', 12, 2)->nullable(); //9
            $table->date('date')->nullable(); //10
            $table->string('accountable_officer'); //11
            $table->string('remarks')->nullable(); //12
            $table->string('account_name'); //13
            $table->string('service'); //14
            $table->string('createdBy'); //15
            $table->string('status'); //16
            $table->string('property_type'); //17
            $table->string('received_from'); //18
            $table->timestamps(); //19
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i_i_r_u_ps');
    }
}
