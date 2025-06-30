<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;

class MusicController extends Controller
{
    public function index()
    {
        $music = Music::with('service')->get(); // optional: eager load service

        return response()->json([
            'message' => 'Available Music Options',
            'music' => $music
        ]);
    }
}