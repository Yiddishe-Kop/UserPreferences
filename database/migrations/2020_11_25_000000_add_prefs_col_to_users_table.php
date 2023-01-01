<?php

use Illuminate\Support\Facades\Schema;
use YiddisheKop\UserPreferences\Support;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefsColToUsersTable extends Migration
{
    public function up()
    {
        Schema::table(Support::getTable(), function (Blueprint $table) {
            $table->json(config('user-preferences.database.column'))->nullable();
        });
    }

    public function down()
    {
        Schema::table(Support::getTable(), function (Blueprint $table) {
            $table->dropColumn(config('user-preferences.database.column'));
        });
    }
}
