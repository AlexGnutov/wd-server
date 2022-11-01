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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 100);
            $table->json('seats')->default(json_encode(
                [
                    ["s","s","s","s","s","s"],
                    ["s","s","s","s","s","s"],
                    ["s","s","s","s","s","s"],
                    ["s","s","s","s","s","s"],
                    ["s","s","s","s","s","s"],
                    ["s","s","s","s","s","s"],
                ]
            ));
            $table->integer('standardPrice')->default(100);
            $table->integer('vipPrice')->default(100);
            $table->boolean('openedForSales')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('halls');
    }
};
