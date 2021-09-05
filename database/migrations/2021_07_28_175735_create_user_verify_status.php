<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerifyStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('verify_status', 1)->default('0');
                $table->dateTime('verify_at')->default(NULL)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'verify_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('verify_status');
                $table->dropColumn('verify_at');
            });
        }
    }
}
