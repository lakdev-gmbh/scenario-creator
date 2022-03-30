<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

class AddUserUuidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('watermelon_id')->nullable();
            $table->softDeletes();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->foreignUuid('user_watermelon_id')->nullable();
        });
        $users = User::all();
        foreach ($users as $user) {
            $user->watermelon_id = Uuid::uuid4()->toString();
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('watermelon_id');
            $table->dropSoftDeletes();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropColumn('user_watermelon_id');
            $table->foreignId('user_id')->nullable();
        });
    }
}
