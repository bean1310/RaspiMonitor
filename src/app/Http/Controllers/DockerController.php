<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Docker;

class DockerController extends Controller
{
    const RESTART_REQUEST = 0;
    const STOP_REQUEST = 1;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function action(Request $request)
    {
        $request->validate([
            'action' => 'required|numeric',
            'container_name' => 'required|string'
        ]);

        $action = $request->input('action');
        $containerName = $request->input('container_name');

        switch ($action) {
            case self::RESTART_REQUEST:
                (new Docker())->exec('restart', $containerName);
                break;

            case self::STOP_REQUEST:
                (new Docker())->exec('stop', $containerName);
            break;

            default:
                // code...
                break;
        }
    }
}
