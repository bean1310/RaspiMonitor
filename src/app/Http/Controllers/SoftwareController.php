<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    private const NOT_RUNNING       = 0;
    private const UPDATING_NOW      = 1;
    private const UPDATE_SUCCESSED  = 2;
    private const UPGRADING_NOW     = 3;
    private const UPGRADE_SUCCESSED = 4;

    private $status;

    function __construct() {
        $this->status = SoftwareController::NOT_RUNNING;
    }

    public function index(Request $request, $command) {

        switch ($command) {
            case 'updateAndUpgrade':
                $this->updateAndUpgrade();
                break;
            
            case 'distUpgrade':
                $this->distUpgrade();
                break;
        }
    }

    private function updateAndUpgrade() {

        if (config('app.debug', false) === true) {
            exec("wall \"apt update && apt upgrade がRaspiMonitorから要求されました。\nデバッグモードのため、実行はされません。\"", $tmp, $isFaild);
            unset($tmp);
            return !$isFaild;
        }

        $this->status = SoftwareController::UPDATING_NOW;
        exec("sudo apt update", $tmp, $isFaild);
        if ($isFaild) {
            
        }

    }
}
