<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('nikname')->nullable();
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('mobile')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();

            $table->string('avatar')->nullable();

            $table->string('gender')->nullable(); // ['male', 'female']
            $table->string('status')->default('waiting'); // ['waiting', 'active', 'block']
            $table->string('type')->default('user'); // ['guest', 'user', 'admin']
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('nikname');
            $table->dropColumn('mobile');
            $table->dropColumn('username');
            $table->dropColumn('google_id');
            $table->dropColumn('facebook_id');
            $table->dropColumn('twitter_id');
            $table->dropColumn('avatar');
            $table->dropColumn('gender');
            $table->dropColumn('status');
            $table->dropColumn('type');
            $table->string('name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
       });
    }
}
