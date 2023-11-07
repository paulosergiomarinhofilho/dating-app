<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceInformationRequest;
use App\Http\Requests\UpdateDeviceInformationRequest;

use App\Models\DeviceInformation;
use App\Models\User;

class DeviceInformationController extends Controller
{
    public function update(UpdateDeviceInformationRequest $request, User $user)
    {
      
        $request->merge(['user_id' => $request->user()->id]);
        $device_information = $request->all();

        $create = DeviceInformation::updateOrCreate(
            ['user_id' => $device_information['user_id']],
            $device_information
        );

        return ['status' => true, 'data' => $create];
    }
}
