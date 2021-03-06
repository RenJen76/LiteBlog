<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'user_picture')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_picture', 255)->nullable();
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
        if (!Schema::hasColumn('users', 'user_picture')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_picture');
            });
        }
    }
}
