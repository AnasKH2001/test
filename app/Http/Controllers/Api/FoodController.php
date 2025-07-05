<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        $food = Food::with('service:id,id,cost')->get(); // optional: eager load service

        $formatted = $food->map(function ($item) {
        return [
            'id' => $item->service->id,
            'description' => $item->description,
            'cost' => $item->service->cost ?? null,
        ];
        });

        return response()->json([
            'message' => 'Available Food Options',
            'food' => $formatted
        ]);
    }
}



