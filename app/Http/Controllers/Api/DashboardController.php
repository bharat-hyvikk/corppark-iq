<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // -> response fields:- todays_check_ins, active_parkings, remaining space.

    public function dashboard(Request $request)
    {
        $building = User::find($request->id)->building;
        if (!$building) {
            return response()->json([
                'success' => 0,
                'message' => 'Building not found',
                'data' => null
            ], 404);
        }
        $todays_check_ins = Vehicle::where(function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck('id'));
        })->whereDate('check_in_time', now()->toDateString())
            ->orWhereDate("check_out_time", now()->toDateString())
            ->count();
        $active_parkings = Vehicle::where(function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck('id'));
        })->where('check_in_status', 'Parked')->count();

        $total_space = Office::where(function ($query) use ($building) {
            $query->whereIn('id', $building->offices->pluck('id'));
        })->sum('vehicle_limit');
        // Assuming you want to calculate remaining space based on total space and active parkings
        $remaining_space = $total_space - $active_parkings;
        $data = [
            'todays_check_ins' => $todays_check_ins,
            'active_parkings' => $active_parkings,
            'remaining_space' => $remaining_space,
        ];
        return response()->json([
            'success' => 1,
            'data' => $data,
            'message' => 'Dashboard data fetched successfully',
        ]);
    }
}
