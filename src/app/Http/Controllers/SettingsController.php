<?php

namespace App\Http\Controllers;

use App\DisplaySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userName = Auth::user()->name;
        $displaySettings = DisplaySettings::find($userName) ?: new DisplaySettings();

        foreach ($displaySettings->attributesToArray() as $key => $value) {
            if (preg_match("/^[^display_]/", $key)) {
                continue;
            }

            $displayContents[$key]['isDisplayed'] = $value;
            $title = str_replace('display_', '', $key);
            $displayContents[$key]['title'] = __('display_contents.' . $title);
        }

        return view('settings', ["displayContents" => $displayContents]);
    }

    public function save(Request $request)
    {
        $displaySettingFormData = $request->all();
        $userName = Auth::user()->name;
        $displaySettings = DisplaySettings::find($userName);
        if (is_null($displaySettings)) {
            $displaySettings = new DisplaySettings();
            $displaySettings->user_name = $userName;
        }

        foreach ($displaySettings->attributesToArray() as $key => $value) {
            if (preg_match("/^(?!display_).*$/", $key)) {
                continue;
            }

            $displaySettings->$key = key_exists($key, $displaySettingFormData) ? 1 : 0;

            $displayContents[$key]['isDisplayed'] = $displaySettings->$key;
            $title = str_replace('display_', '', $key);
            $displayContents[$key]['title'] = __('display_contents.' . $title);
        }

        $isSucceed = $displaySettings->save();

        return view('settings', compact('displayContents', 'isSucceed'));
    }

}
