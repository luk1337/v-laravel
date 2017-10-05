<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserListAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_list_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('steamid');
            $table->string('avatar');
            $table->string('name');
            $table->integer('number_of_vac_bans');
            $table->integer('number_of_game_bans');
            $table->date('last_ban_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_list_accounts');
    }
}
