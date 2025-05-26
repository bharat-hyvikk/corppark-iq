<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
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
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found', 'success' => '0'], 404);
        }
        // set  status 
        if ($request->input('status') == 'Parked') {
            $vehicle->check_in_time = now();
            $vehicle->check_out_time = null;
        } else {
            $vehicle->check_out_time = now();
            $vehicle->check_in_time = null;
        }
        $vehicle->check_in_status = $request->input('status');
        $vehicle->save();
        return response()->json([
            'message' => 'Vehicle check-in status updated successfully',
            'success' => 1,
        ]);
    }
}
