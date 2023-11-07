<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppSettingRequest;
use App\Http\Requests\UpdateAppSettingRequest;
use Illuminate\Http\Request;

use App\Models\AppSetting;
use App\Models\User;


class AppSettingController extends Controller
{
    public function index(Request $request)
    {
       $AppSetting = AppSetting::get();
       return ['status'=>true,'data'=>$AppSetting];
    }

    public function show($key)
    {
        $appSetting = AppSetting::where('key', $key)->first();
        return ['status'=>true, 'data'=>$appSetting];
 
    }

    public function update($key, Request $request)
    {
        //$this->authorize('update', AppSetting::class);
        
        $appSetting = AppSetting::updateOrCreate(
            ['key' =>  request('key')],
            ['value' => request('value')]
        );
        return ['status'=>true,'data'=>$appSetting];
    }


    public function destroy(Request $request, $key)
    {
        //$this->authorize('delete', AppSetting::class);
        $appSetting = AppSetting::where('key', $key)->first();
        $appSetting->delete();

        return ['status'=>true];
    }

}
