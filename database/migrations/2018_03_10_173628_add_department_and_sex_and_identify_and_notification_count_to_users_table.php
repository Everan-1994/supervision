<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentAndSexAndIdentifyAndNotificationCountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('department_id')->unsigned();
            $table->enum('sex', [1, 2]);
            $table->enum('identify', [1, 2]);
            $table->integer('notification_count')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('sex');
            $table->dropColumn('identify');
            $table->dropColumn('notification_count');
        });
    }
}
