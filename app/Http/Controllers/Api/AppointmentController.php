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
        'customer_id' => $user->customer->id,  // استخدام ID من جدول customers
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


public function updateAppointmentStatus(Request $request, $id)
{
    $user = auth()->user();

    $appointment = Appointment::find($id);

    if (!$appointment) {
        return response()->json(['message' => 'Appointment not found'], 404);
    }

    // تحقق إذا المستخدم هو مزود الخدمة لهذا الموعد
    if ($user->provider && $appointment->provider_id === $user->provider->id) {
        $appointment->status = $request->input('status');
        $appointment->save();

        return response()->json(['message' => 'Status updated successfully', 'appointment' => $appointment]);
    }

    return response()->json(['message' => 'Unauthorized to update this appointment'], 403);
}
public function getAcceptedAppointmentsForCustomer()
{
    $user = Auth::user();

    // تحقق أن المستخدم لديه ملف زبون
    if (!$user || !$user->customer) {
        return response()->json(['message' => 'No customer profile found.'], 404);
    }

    // جلب المواعيد مع معلومات الخدمة، المزود (مع المستخدم)، والزبون (مع المستخدم)
    $appointments = Appointment::with([
            'service',
            'provider.user',  // اسم المزود
            'customer.user'   // اسم الزبون
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



public function getAcceptedAppointmentsForProvider()
{
    $user = Auth::user();

    // تحقق أن المستخدم لديه ملف مزود
    if (!$user || !$user->provider) {
        return response()->json(['message' => 'No provider profile found.'], 404);
    }

    // جلب المواعيد مع معلومات الخدمة والزبون والمزود
    $appointments = Appointment::with([
            'service',
            'customer.user',   // اسم الزبون
            'provider.user'    // اسم المزود
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
}