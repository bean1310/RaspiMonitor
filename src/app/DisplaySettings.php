<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisplaySettings extends Model
{
    protected $primaryKey = 'user_name';

    protected $attributes = [
        'display_network_status' => true,
        'display_system_status' => true,
        'display_software_info' => true,
        'display_power_control' => true,
    ];
}
