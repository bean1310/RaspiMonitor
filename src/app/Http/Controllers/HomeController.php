<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $nics = [];
    private $cpuInfo = [];
    private $memoryInfo = [];
    // private $disksInfo = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->nics = $this->getNicInfo();
        $this->cpuInfo = $this->getCpuInfo();
        $this->memoryInfo = $this->getMemoryInfo();
        $this->disksInfo = $this->getDisksInfo();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ["nics" => $this->nics, "cpuInfo" => $this->cpuInfo, "memoryInfo" => $this->memoryInfo, "disksInfo" => $this->disksInfo]);
    }

    private function getNicInfo() {

        exec("ip -j a", $networkData, $isFailed);

        if (!$isFailed) {
            $networkInfo = json_decode($networkData[0], true);
            $nics = array();
            foreach ($networkInfo as $interface) {
                if ($interface["link_type"] == "ether") {
                    array_push($nics, $interface);
                }
            }

            foreach ($nics as &$nic) {
                $newNic = [
                    "ifname"     => $nic["ifname"],
                    "details"    => $nic["addr_info"],
                    "macAddress" => $nic["address"],
                ];
                if (strpos($newNic["ifname"], "eth") !== false) {
                    $newNic["name"] = "Ethernet";
                } else if (strpos($newNic["ifname"], "wlan") !== false) {
                    $newNic["name"] = "Wi-Fi";
                } else {
                    $newNic["name"] = "Unknown";
                }
                $nic = $newNic;
            }

            foreach ($nics as &$nic) {
                foreach ($nic["details"] as &$addrInfo) {
                    $newAddrInfo = [
                        "ipAddress" => $addrInfo["local"],
                        "prefixLen" => $addrInfo["prefixlen"],
                    ];

                    switch ($addrInfo["family"]) {
                        case 'inet':
                            $newAddrInfo["ipVersion"] = "IPv4";
                            break;

                        case 'inet6':
                            $newAddrInfo["ipVersion"] = "IPv6";
                            break;
                        
                        default:
                            $newAddrInfo["ipVersion"] = "IPv?";
                            break;
                    }
                    $addrInfo = $newAddrInfo;
                }
            }

            return $nics;
        }
        
    }

    private function getCpuInfo() {

        exec("lscpu -J", $cpuRawData, $isFailed);
        if (!$isFailed) {
            $cpuJsonData = "";

            foreach ($cpuRawData as $oneLine) {
                $cpuJsonData .= $oneLine;
            }

            $cpuInfoArray = json_decode($cpuJsonData, true);
            $cpuInfoArray = $cpuInfoArray["lscpu"];
            $cpuInfo["modelName"]= $this->getDataValueFromCpuInfoArray("Model name:", $cpuInfoArray);
            $cpuInfo["cores"]= $this->getDataValueFromCpuInfoArray("CPU(s):", $cpuInfoArray);
            
        } else {
            return null;
        }

        if (config('app.debug', false) === false) {
            exec("cat /sys/class/thermal/thermal_zone0/temp", $cpuTempRawData, $isFailed);
            if (!$isFailed) {
                $cpuInfo["temp"] = round($cpuTempRawData[0] / 1000);
            }
        } else {
            $cpuInfo["temp"] = "50(Pseudo value)";
        }

        return $cpuInfo;
    }

    private function getMemoryInfo() {

        exec("cat /proc/meminfo", $memoryRawData, $isFailed);
        if (!$isFailed) {
            $allMemoryInfo = array();
            foreach ($memoryRawData as $oneLine) {
                // 実装がクソな気がする
                $oneOfMemoryInfo = $this->procMeminfoOutputToArray($oneLine);
                $oneOfMemoryInfo[array_keys($oneOfMemoryInfo)[0]] = rtrim(array_values($oneOfMemoryInfo)[0], " kB");
                $allMemoryInfo += $oneOfMemoryInfo;
            }

            $memoryInfo["memoryTotalSize"]               = $this->convertByteNumberToHumanReadableString($allMemoryInfo["MemTotal"]);
            $bufferAndCachedMemoryValue                  = intval($allMemoryInfo["Buffers"]) + intval($allMemoryInfo["Cached"]);
            $memoryInfo["memoryBuffersAndCachedPercent"] = round($bufferAndCachedMemoryValue / intval($allMemoryInfo["MemTotal"]) * 100);
            $usedMemoryValue                             = intval($allMemoryInfo["MemTotal"]) - intval($allMemoryInfo["Buffers"]) - intval($allMemoryInfo["Cached"]) - intval($allMemoryInfo["MemFree"]);
            $memoryInfo["memoryUsedPercent"]             = round( $usedMemoryValue / intval($allMemoryInfo["MemTotal"]) * 100);
            $memoryInfo["swapTotalSize"]                 = $this->convertByteNumberToHumanReadableString($allMemoryInfo["SwapTotal"]);
            $memoryInfo["swapUsedPercent"]               = round(intval($allMemoryInfo["SwapFree"]) / intval($allMemoryInfo["SwapTotal"]));
        
        } else {
            return null;
        }

        return $memoryInfo;
    }

    /**
     * バイト数を人間が読みやすい形式の文字列に変換する関数
     * 
     * とりあえずIECの二進接頭辞での出力. そのうちconfigなど見て変えれるようにしたいね.
     *
     * @param int|string $num   変換対象の数値
     * @param integer $nowUnit  変換対象の変換時の単位
     * @return string
     */
    private function convertByteNumberToHumanReadableString($num, $nowUnit = 0) {

        static $siUnitArray = ['Byte', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        static $unitArray = ['Byte', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];

        if (strlen($num) >= 4) {
            $carriedNumber = round($num / 1024);
            return $this->convertByteNumberToHumanReadableString($carriedNumber, $nowUnit + 1);
        }
            return $num . $unitArray[$nowUnit];
    }

    private function getDisksInfo() {

        exec("df -h", $diskRawDatas, $isFailed);

        if (!$isFailed) {
            $disksData = $this->dfOutputToArray($diskRawDatas);
        } else {
            return null;
        }

        foreach ($disksData as $diskData) {
            if (strpos($diskData["fileSystem"], "/dev") === 0) {
                static $cnt = 0;
                $disksInfo[$cnt] = $diskData;
                $cnt++;
            }
        }

        return $disksInfo;

    }

    private function dfOutputToArray($dfCommandOutPut) {

        $line = 0;
        foreach ($dfCommandOutPut as $oneLine) {
            $resultStrArray = preg_split("/\s+/", $oneLine);
            $result[$line]["fileSystem"]  = $resultStrArray[0];
            $result[$line]["size"]        = $resultStrArray[1];
            $result[$line]["used"]        = $resultStrArray[2];
            $result[$line]["avalable"]    = $resultStrArray[3];
            $result[$line]["usedPercent"] = rtrim($resultStrArray[4], '%');
            $result[$line]["mountPoint"]  = $resultStrArray[5];
            $line++;
        }

        return $result;
    }

    /**
     * /proc/meminfo の内容ををArrayに変換する関数
     * 
     * "hoge:foo" to array("hoge" => "foo")
     *
     * @return array
     */
    private function procMeminfoOutputToArray(string $str) {
        $resultStr = explode(':', $str);
        $resultStr[1] = trim($resultStr[1]);
        return array($resultStr[0] => $resultStr[1]);
    }

    /**
     * lscpu -J のデータをデコードしたものから指定したfield値のdata値を取る関数
     */
    private function getDataValueFromCpuInfoArray(string $fieldName, array $cpuJsonDataArray) {

        foreach($cpuJsonDataArray as $cpuJsonData) {
            if ($cpuJsonData['field'] == $fieldName) {
                return $cpuJsonData['data'];
            }
        }

        return null;
    }

    private function softwareUpdateAndUpgrade() {

    }

    private function distUpgrade() {

    }

}