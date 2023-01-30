<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scenarios_user_groups', function (Blueprint $table) {
            $table->uuid('watermelon_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scenarios_user_groups', function (Blueprint $table) {
            $table->dropColumn('watermelon_id');
            $table->dropSoftDeletes();
            $table->dropTimestamps();
        });
    }
};
