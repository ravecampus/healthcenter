<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineDispenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_dispense', function (Blueprint $table) {
            $table->id();
            $table->integer('diagnos_id')->nullable();
            $table->integer('medicine_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('every_take')->nullable();
            $table->integer('times')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('medicine_dispense');
    }
}
