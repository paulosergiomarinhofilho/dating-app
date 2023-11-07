<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Like;

class LikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        //$request->merge(['user_id' => $request->user()->id]);

        $like = Like::firstOrCreate(
            $data
        );

        return $like;
    }
}
