<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;

class MusicController extends Controller
{
    public function index()
    {
        $music = Music::with('service:id,id,cost')->get(); // optional: eager load service

        $formatted = $music->map(function ($item) {
        return [
            'id' => $item->service->id,
            'description' => $item->description,
            'cost' => $item->service->cost ?? null,
        ];
        });

        return response()->json([
            'message' => 'Available Music Options',
            'music' => $formatted
        ]);
    }
}