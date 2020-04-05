<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class PowerController extends Controller
{

    private static $__execedCommand;

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $command)
    {
        $isQuick = $request->get('isQuick', false);

        switch ($command) {
            case 'poweroff':
                $isSuccessed = $this->__execShutdow($isQuick, $isReboot = false);
                break;

            case 'reboot':
                $isSuccessed = $this->__execShutdow($isQuick, $isReboot = true);
                break;

            case 'cancel':
                $isSuccessed = $this->__cancelShutdownCommandExecution();
                break;
        }

        if (!$isSuccessed) {
            Log::error('Failed to shutdown');
        }

        return ["isSuccessed" => $isSuccessed];
    }

    /**
     * Execute shutdown or reboot
     *
     * if shutdown/reboot command is success return true
     *
     * @param boolean $isQuick
     * @param string $isReboot
     * @return bool
     */
    private function __execShutdow(bool $isQuick = false, string $isReboot): bool
    {

        if (is_null($isReboot)) {
            throw new BadFunctionCallException('$isReboot was not given a value');
        }

        $rebootString = $isReboot ? 'Reboot' : 'Shutdown';
        $shutdownCommandOption = $isReboot ? 'r' : 'h';

        if ($isQuick) {
            Log::notice("RaspiMonitor exec quick $rebootString");
            if (config('app.debug', false) === true) {
                Log::debug('RaspiMonitor called Quick ' . $rebootString . ', but will not executing because this environment is DEBUG');
                return 1;
            } else {
                exec("sudo shutdown -" . $shutdownCommandOption . " now", $unuse, $isFaild);
                return !$isFaild;
            }

        } else {
            Log::notice("RaspiMonitor exec $rebootString");
            if (config('app.debug', false) === true) {
                Log::debug('RaspiMonitor called ' . $rebootString . ', but will not executing because this environment is DEBUG');
                return 1;
            } else {
                exec('wall "This computer will ' . $rebootString . ' after 1 min by RaspiMonitor."');
                exec("sudo shutdown -" . $shutdownCommandOption . ' +1', $unuse, $isFaild);
                return !$isFaild;
            }
        }

    }

    private function __cancelShutdownCommandExecution()
    {

        if (config('app.debug', false) === true) {
            Log::debug('RaspiMonitor stop executing shutdown/reboot');
            return 1;
        }

        exec("sudo shutdown -c", $tmp, $isFailed);

        return !$isFailed;

    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
