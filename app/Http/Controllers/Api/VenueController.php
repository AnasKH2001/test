<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with('service')->get(); // optional: eager load service

        return response()->json([
            'message' => 'Available Venues',
            'venues' => $venues
        ]);
    }
}
