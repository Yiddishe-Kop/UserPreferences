<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefsColToUsersTable extends Migration
{
    public function up()
    {
        Schema::table(config('user-preferences.database.table'), function (Blueprint $table) {
            $table->json(config('user-preferences.database.column'))->nullable();
        });
    }

    public function down()
    {
        Schema::table(config('user-preferences.database.table'), function (Blueprint $table) {
            $table->dropColumn(config('user-preferences.database.column'));
        });
    }
}
