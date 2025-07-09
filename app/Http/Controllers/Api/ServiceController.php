<?php


namespace App\Http\Controllers\Api;

use App\Models\Food;
use App\Models\Music;
use App\Models\Venue;
use App\Models\Service;
use App\Models\Provider;
use App\Models\Photography;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:food,music,venues,photography',
            'cost' => 'required|numeric',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer', // for venue
            'location' => 'nullable|string',  // for venue
        ]);

        $user = $request->user();
        $provider = Provider::where('user_id', $user->id)->first();


        // Create the service
        $service = Service::create([
            'provider_id' => $provider->id,
            'service_type'=>$request->type,
            'cost' => $request->cost,
            'description' => $request->description,

        ]);

        // Create the related record
        switch ($request->type) {
            case 'food':
                Food::create([
                    'service_id' => $service->id,
                    'description' => $request->description,
                ]);
                break;

            case 'music':
                Music::create([
                    'service_id' => $service->id,
                    'description' => $request->description,
                ]);
                break;

            case 'venues':
                Venue::create([
                    'service_id' => $service->id,
                    'location' => $request->location,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
                ]);
                break;

            case 'photography':
                Photography::create([
                    'service_id' => $service->id,
                    'description' => $request->description,
                ]);
                break;
        }

        return response()->json([
            'message' => 'Service created successfully',
            'service_id' => $service->id,
            'type' => $request->type,
        ], 201);
    }


    public function index()
    {
        $user = Auth::user();
        $provider = Provider::where('user_id', $user->id)->first();

        $services = Service::where('provider_id', $provider->id)
            ->get();

        return response()->json([
            'message' => 'Your Services',
            'services' => $services
        ]);
    }


    public function destroy($id)
    {
        $user = Auth::user();
        $provider = Provider::where('user_id', $user->id)->first();

        $service = Service::findOrFail($id);

        // Ensure the service belongs to the authenticated provider
        if ($service->provider_id !== $provider->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete related record based on type
        Food::where('service_id', $service->id)->delete();
        Venue::where('service_id', $service->id)->delete();
        Music::where('service_id', $service->id)->delete();
        Photography::where('service_id', $service->id)->delete();

        // Delete the service itself
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
