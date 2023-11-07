<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDislikeRequest;
use App\Http\Requests\UpdateDislikeRequest;
use App\Models\Dislike;

class DislikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDislikeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        //$request->merge(['user_id' => $request->user()->id]);

        $dislike = Dislike::firstOrCreate(
            $data
        );

        return $like;
    }
}
