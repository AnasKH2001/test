<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photography;

class PhotographyController extends Controller
{
    public function index()
    {
        $photography = Photography::with('service')->get(); // optional: eager load service

        return response()->json([
            'message' => 'Available Photography Services',
            'photography' => $photography
        ]);
    }
}
