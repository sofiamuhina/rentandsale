<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBargainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('bargains', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->decimal('price', 12, 2)->nullable();
            $table->integer('status_id')->default(1); 
            $table->integer('object_id')->nullable();
            $table->integer('customer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bargains');
    }
}
