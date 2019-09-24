<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity_name'); //1 Entity-Name 
            $table->string('service'); //2 Service
            $table->string('request_number'); //3 RIS number
            $table->string('unit_of_measure'); //4 Unit of Measure
            $table->string('description'); //5
            $table->decimal('quantity', 12, 2); //6
            $table->string('status'); //7 //Available? Pending or Approved?
            $table->string('remarks')->nullable(); //8
            $table->string('purpose'); //9
            $table->string('accountable_officer'); //10 Requested by
            $table->string('issued_by')->nullable(); //11 Approved by
            $table->string('received_by')->nullable(); //12 Received by
            $table->string('createdBy')->nullable(); //12 Received by
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
        Schema::dropIfExists('request_assets');
    }
}
