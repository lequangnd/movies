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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image');
            $table->string('token')->nullable();
            $table->integer('active');
            $table->integer('social');
            $table->string('text_password');
            $table->unsignedBigInteger('decentralization_id');
            $table->foreign('decentralization_id')->references('id')->on('decentralization');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('level');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
