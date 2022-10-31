<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('startTime');

            $table->unsignedBigInteger('hallId');
            $table->foreign('hallId')->references('id')->on('halls');

            $table->unsignedBigInteger('filmId');
            $table->foreign('filmId')->references('id')->on('films');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
};
