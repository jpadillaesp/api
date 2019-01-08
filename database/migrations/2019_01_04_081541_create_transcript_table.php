<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranscriptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcript', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('transcript');
            $table->longText('file_b64');
            $table->string('star_time');
            $table->string('end_time');
            $table->integer('words');
            $table->integer('orchestrator_room_id')->unsigned();
            $table->foreign('orchestrator_room_id')->references('id')->on('orchestrator_room');
            $table->tinyInteger('disabled');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transcript');
    }
}

