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

            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();

            $table->string('nikname')->nullable()->after('name');
            $table->string('mobile')->unique()->nullable()->after('email');
            $table->string('username')->unique()->nullable()->after('mobile');
            $table->string('google_id')->unique()->nullable()->after('username');
            $table->string('facebook_id')->unique()->nullable()->after('google_id');
            $table->string('twitter_id')->unique()->nullable()->after('facebook_id');

            $table->string('avatar')->nullable()->after('facebook_id');

            $table->string('gender')->nullable()->after('avatar'); // ['male', 'female']
            $table->string('status')->default('waiting')->after('gender'); // ['waiting', 'active', 'block']
            $table->string('type')->default('user')->after('status'); // ['guest', 'user', 'admin']
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
