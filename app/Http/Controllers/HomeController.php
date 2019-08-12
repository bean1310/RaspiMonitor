<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        exec("ip -f inet address | grep inet | grep eth", $str, $res);
        var_dump($_SERVER);
        var_dump($res);
        $wifiIpAddress = "";
        phpinfo();
        return view('home', \compact("wifiIpAddress"));
    }
}
