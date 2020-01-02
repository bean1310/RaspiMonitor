<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisplaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('display_settings', function (Blueprint $table) {
            $table->string('user_name');
            $table->boolean('display_network_status');
            $table->boolean('display_system_status');
            $table->boolean('display_software_info');
            $table->boolean('display_power_control');
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
        Schema::dropIfExists('display_settings');
    }
}
