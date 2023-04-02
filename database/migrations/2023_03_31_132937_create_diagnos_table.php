<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnos', function (Blueprint $table) {
            $table->id();
            $table->integer('service_request_id')->nullable();
            $table->integer('consultation_id')->nullable();
            $table->string('diagnosis_name')->nullable();
            $table->string('symtoms')->nullable();
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
        Schema::dropIfExists('diagnos');
    }
}
