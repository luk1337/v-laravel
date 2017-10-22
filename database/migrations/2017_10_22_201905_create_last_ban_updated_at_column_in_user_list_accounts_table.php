<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastBanUpdatedAtColumnInUserListAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_list_accounts', function (Blueprint $table) {
            $table->timestamp('last_ban_updated_at')->after('last_ban_date');
        });

        \DB::statement('UPDATE `user_list_accounts` SET last_ban_updated_at = last_ban_date');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_list_accounts', function (Blueprint $table) {
            $table->dropColumn('last_ban_updated_at');
        });
    }
}
