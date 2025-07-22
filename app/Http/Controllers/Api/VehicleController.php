<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // -> request_field:- id, api_token, office_no, vehicle_no.
    public function checkInStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'vehicle_no' => 'required|exists:vehicles,vehicle_number',
                "status" => 'required|in:Parked,Not Parked',
            ],
            [
                'vehicle_no.required' => 'Vehicle number is required',
                'vehicle_no.exists' => 'Vehicle number does not exist',
                'status.required' => 'Status is required',
                'status.in' => 'Status must be either Parked or Not Parked',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $vehicle = Vehicle::where('vehicle_number', $request->input('vehicle_no'))->first();
        $building = User::find($request->id)->building;
        if (!$vehicle || !$building->offices->pluck('id')->contains($vehicle->office_id)) {
            return response()->json([
                'success' => 0,
                'message' => 'Vehicle not found',
            ], 404);
        }
        // set  status 
        if ($request->input('status') == 'Parked') {
            $vehicle->check_in_time = now();
            $vehicle->check_out_time = null;
        } else {
            $vehicle->check_out_time = now();
            // $vehicle->check_in_time = null;
        }
        // log the check-in status change
        $buildingName = str_replace(' ', '_', $vehicle->office->building->building_name);

        $logPath = storage_path('logs/daily-check-in/' . $buildingName . '/' . date('Y') . '/' . date('F') . '/' . date('Y-m-d') . '.log');

        config(['logging.channels.daily_check_in_dynamic.path' => $logPath]);

        Log::channel('daily_check_in_dynamic')->info(
            'Vehicle ID: ' . $vehicle->id .
                ' | Vehicle Number: ' . $vehicle->vehicle_number .
                ' | Owner Phone: ' . $vehicle->owner_phone .
                ' | Check-in Status: ' . $request->input('status') .
                ' | Office Name: ' . $vehicle->office->office_name .
                ' | Building Name: ' . $vehicle->office->building->building_name
        );
        $vehicle->check_in_status = $request->input('status');
        $vehicle->saveQuietly();
        return response()->json([
            'message' => 'Vehicle check-in status updated successfully',
            'success' => 1,
        ]);
    }
}
