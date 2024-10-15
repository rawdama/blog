<?php

namespace App\Http\Controllers\Api;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index(){
        $settings=Setting::checkSettings();
        $settings=SettingResource::make($settings);
        return response()->json([
            'data'=>$settings,
            'error'=>'',
        ]);
    }
}
