<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        $food = Food::with('service')->get(); // optional: eager load service

        return response()->json([
            'message' => 'Available Food Options',
            'food' => $food
        ]);
    }
}