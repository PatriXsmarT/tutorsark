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
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('abilitables', function (Blueprint $table) {
            $table->unique(['abilitable_type','abilitable_id','ability_id']);

            $table->id();
            $table->string('abilitable_type');
            $table->unsignedBigInteger('abilitable_id');
            $table->unsignedBigInteger('ability_id');
            $table->timestamps();

            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abilitables');
        Schema::dropIfExists('abilities');
    }
};
