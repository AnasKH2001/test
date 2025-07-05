<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venue = Venue::with('service:id,id,cost')->get(); // optional: eager load service

        $formatted = $venue->map(function ($item) {
        return [
            'id' => $item->service->id,
            'capacity' => $item->capacity,
            'location' => $item->location,
            'description' => $item->description,
            'cost' => $item->service->cost ?? null,
        ];
        });

        return response()->json([
            'message' => 'Available Venue Options',
            'venue' => $formatted
        ]);
    }
}
