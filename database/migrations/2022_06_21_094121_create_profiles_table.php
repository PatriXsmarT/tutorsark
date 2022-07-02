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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('gender');
            $table->string('occupation')->default('Teacher');
            $table->string('dob');
            $table->text('bio');
            $table->string('website')->nullable();
            $table->string('phone_number')->unique();
            $table->string('address');
            $table->string('town');
            $table->string('state');
            $table->string('country')->default('Nigeria');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
