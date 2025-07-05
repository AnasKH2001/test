<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photography;

class PhotographyController extends Controller
{
    public function index()
    {
        $photography = Photography::with('service:id,id,cost')->get(); // optional: eager load service

        $formatted = $photography->map(function ($item) {
        return [
            'id' => $item->service->id,
            'description' => $item->description,
            'cost' => $item->service->cost ?? null,
        ];
        });

        return response()->json([
            'message' => 'Available Photography Options',
            'photography' => $formatted
        ]);
    }
}
