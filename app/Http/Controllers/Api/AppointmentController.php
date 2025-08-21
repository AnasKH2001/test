<?php

namespace App\Http\Controllers\Api;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{


    //حجز موعد من قبل الزبون
public function requestAppointment(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'appointment_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'description' => 'nullable|string',
    ]);

    $user = Auth::user();

    if (!$user->customer) {
        return response()->json(['message' => 'No customer profile found for this user.'], 422);
    }

    $service = Service::findOrFail($request->service_id);

    $appointment = Appointment::create([
        'service_id' => $service->id,
        'provider_id' => $service->provider_id,
        'customer_id' => $user->customer->id,  
        'appointment_date' => $request->appointment_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'status' => 'pending',
        'description' => $request->description,
    ]);

    return response()->json([
        'message' => 'Appointment request sent.',
        'data' => $appointment
    ], 201);
}



//قبول و رفض ....الموعد  من قبل المزود
public function updateAppointmentStatus(Request $request, $id)
{
    $user = auth()->user();

    $appointment = Appointment::find($id);

    if (!$appointment) {
        return response()->json(['message' => 'Appointment not found'], 404);
    }

    if ($user->provider && $appointment->provider_id === $user->provider->id) {
        $appointment->status = $request->input('status');
        $appointment->save();

        return response()->json(['message' => 'Status updated successfully', 'appointment' => $appointment]);
    }

    return response()->json(['message' => 'Unauthorized to update this appointment'], 403);


}

//ارجاع المواعيد التي تم قبولها للزبون
public function getAcceptedAppointmentsForCustomer()
{
    $user = Auth::user();

    if (!$user || !$user->customer) {
        return response()->json(['message' => 'No customer profile found.'], 404);
    }

    $appointments = Appointment::with([
            'service',
            'provider.user',  
            'customer.user'   
        ])
        ->where('customer_id', $user->customer->id)
        ->where('status', 'accepted')
        ->get();

    if ($appointments->isEmpty()) {
        return response()->json(['message' => 'No accepted appointments found for this customer.'], 404);
    }

    return response()->json([
        'message' => 'Accepted appointments fetched successfully',
        'data' => $appointments
    ]);
}



//ارجاع المواعيد التي تم قبولها للمزود
public function getAcceptedAppointmentsForProvider()
{
    $user = Auth::user();

    if (!$user || !$user->provider) {
        return response()->json(['message' => 'No provider profile found.'], 404);
    }

    $appointments = Appointment::with([
            'service',
            'customer.user',   
            'provider.user'    
        ])
        ->where('provider_id', $user->provider->id)
        ->where('status', 'accepted')
        ->get();

    if ($appointments->isEmpty()) {
        return response()->json(['message' => 'No accepted appointments found for this provider.'], 404);
    }

    return response()->json([
        'message' => 'Accepted appointments fetched successfully',
        'data' => $appointments
    ]);
}


// حذف الموعد من قبل الزبون
public function deleteAppointment($id)
{
    $user = Auth::user();

    if (!$user || !$user->customer) {
        return response()->json(['message' => 'No customer profile found.'], 404);
    }

    $appointment = Appointment::where('id', $id)
        ->where('customer_id', $user->customer->id)
        ->first();

    if (!$appointment) {
        return response()->json(['message' => 'Appointment not found or does not belong to this customer.'], 404);
    }

    $appointment->delete();

    return response()->json([
        'message' => 'Appointment deleted successfully.'
    ]);
}


//ارجاع المواعيد المعلقة للمزود
public function getPendingAppointmentsForProvider()
{
    $user = Auth::user();

    if (!$user || !$user->provider) {
        return response()->json(['message' => 'No provider profile found.'], 404);
    }

    $appointments = Appointment::with([
            'service',
            'customer.user',   
            'provider.user'    
        ])
        ->where('provider_id', $user->provider->id)
        ->where('status', 'pending')
        ->get();

    if ($appointments->isEmpty()) {
        return response()->json(['message' => 'No pending appointments found for this provider.'], 404);
    }

    return response()->json([
        'message' => 'Pending appointments fetched successfully',
        'data' => $appointments
    ]);
}


public function getPendingAppointmentsForCustomer()
{
    $user = Auth::user();

    if (!$user || !$user->customer) {
        return response()->json(['message' => 'No customer profile found.'], 404);
    }

    $appointments = Appointment::with([
            'service',
            'provider.user',  
            'customer.user'   
        ])
        ->where('customer_id', $user->customer->id)
        ->where('status', 'pending')
        ->get();

    if ($appointments->isEmpty()) {
        return response()->json(['message' => 'No accepted appointments found for this customer.'], 404);
    }

    return response()->json([
        'message' => 'Accepted appointments fetched successfully',
        'data' => $appointments
    ]);
}

}