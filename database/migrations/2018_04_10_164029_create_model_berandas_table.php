<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelBerandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beranda', function (Blueprint $table) {
            $table->increments('IdBeranda');
            $table->foreign('NIM');
            $table->text('status');
            $table->text('file');
            $table->text('lokasi');
            $table->longText('timestatus');
            $table->integer('isPost');
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
        Schema::dropIfExists('model_berandas');
    }
}
