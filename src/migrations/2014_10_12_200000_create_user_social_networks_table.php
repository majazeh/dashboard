<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSocialNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('social_network')->nullable();
            $table->string('social_network_id')->nullable();
            $table->string('social_network_user')->nullable();
            $table->string('social_network_avatar')->nullable();
            $table->text('response')->nullable();
            $table->enum('verify', ['waiting', 'verified', 'expired'])->default('waiting');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('user_social_networks');
    }
}
