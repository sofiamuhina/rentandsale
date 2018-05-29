<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('description')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('yardage', 12, 2)->nullable();
            $table->string('address')->nullable();
            $table->integer('status_id')->default(1); 
            $table->integer('district_id')->nullable();
            $table->integer('owner_id')->nullable();
            $table->boolean('is_sale')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}
