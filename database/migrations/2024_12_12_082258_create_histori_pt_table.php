<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriPtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_pt', function (Blueprint $table) {
            $table->id(); 
            $table->uuid('uuid')->unique(); 
            $table->string('kode_pt'); 
            $table->string('nama_pt'); 
            $table->string('status_pt'); 
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
        Schema::dropIfExists('histori_pt');
    }
}
