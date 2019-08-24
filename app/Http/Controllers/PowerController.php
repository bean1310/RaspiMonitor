<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PowerController extends Controller
{

    private static $execedCommand;

    public function __construct () {

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
            $isSuccessed = $this->execShutdow($isQuick, $isReboot = false);
            break;
            
            case 'reboot':
            $isSuccessed = $this->execShutdow($isQuick, $isReboot = true);
            break;

            case 'cancel':
            $isSuccessed = $this->cancelShutdownCommandExecution();
            break;
        }

        return ["isSuccessed" => $isSuccessed];
    }

    private function execShutdow($isQuick = false, $isReboot) {

        if (is_null($isReboot)) {
            throw new BadFunctionCallException('$isReboot was not given a value');
        }

        $quickString  = !$isQuick ? "" : "即時";
        $rebootString = $isReboot ? "再起動" : "シャットダウン";

        if (config('app.debug', false) === true) {
            exec("wall \"" . $quickString . $rebootString . "がRaspiMonitorから要求されました。\nデバッグモードのため、実行はされません。\"", $tmp, $isFaild);
            return !$isFaild;
        }

        $shutdownCommandOption = $isReboot ? 'r' : 'h';

        if ($isQuick) {
            exec("sudo shutdown -" . $shutdownCommandOption . " now", null, $isFaild);
            return !$isFaild;
        } else {
            $this->execedCommand = $isReboot;
            exec("sudo shutdown -" . $shutdownCommandOption . " +1 -k \"RaspiMonitorにより、1分後に" . $rebootString . "を行います。\"", $tmp, $isFaild);
            return !$isFaild;
        }

    }

    private function cancelShutdownCommandExecution() {

        if (config('app.debug', false) === true) {
            exec("wall \"シャットダウン処理のキャンセルが実行されました.\"", $tmp, $isFaild);
            return !$isFaild;
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
