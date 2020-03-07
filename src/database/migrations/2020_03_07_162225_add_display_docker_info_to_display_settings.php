<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayDockerInfoToDisplaySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('display_settings', function (Blueprint $table) {
            $table->boolean('display_docker_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('display_settings', function (Blueprint $table) {
            $table->dropColumn('display_docker_info');
        });
    }
}
