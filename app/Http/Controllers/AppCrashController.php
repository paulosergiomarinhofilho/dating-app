<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppCrashRequest;
use App\Http\Requests\UpdateAppCrashRequest;
use Illuminate\Http\Request;
use App\Models\AppCrash;

class AppCrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $appCrash = AppCrash::latest();

        $q = $request->q;
 
        if ($request->os) {
            $appCrash->where('os', $request->os);
        }

        if ($request->type) {
            $appCrash->where('type', $request->type);
        }

        if ($request->user_id) {
            $appCrash->where('user_id', $request->user_id);
        }

        if ($q) {
                $appCrash->where(function ($query) use ($q) {
                    $query->where('message', 'like', "%{$q}%");
            });
        }

       $appCrash = $appCrash->paginate(50);

        $data = collect(['status' => true]);
        $data = $data->merge($appCrash);

        return $data;
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppCrashRequest $request)
    {
        $appCrash = AppCrash::create($request->all());
        $response = ['status' => true, 'data' => $appCrash];
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(AppCrash $appCrash)
    {
        $response = ['status' => true, 'data' => $appCrash];
        return $response;
    }

   
}
