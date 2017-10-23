<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLastBanUpdatedColumnToDatetimeInUserListAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_list_accounts', function (Blueprint $table) {
            $table->dateTime('last_ban_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_list_accounts', function (Blueprint $table) {
            $table->date('last_ban_date')->change();
        });
    }
}
