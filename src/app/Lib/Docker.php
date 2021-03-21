<?php

namespace App\Lib;

// Definitions of Docker command
class Docker extends ExecutableCommand
{
    public function __construct()
    {
        $availableSubCommands = [
            'ps',
            'restart',
            'stop'
        ];
        parent::__construct('docker', $availableSubCommands);
    }
}
