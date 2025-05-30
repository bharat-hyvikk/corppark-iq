<?php

namespace App\Http\Controllers;

use App\Models\InvoiceMgmt;
use App\Models\Office;
use App\Models\QrCode;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $totalUsers = User::where("user_type", "0")->count();
        $totalOffices = Office::count();
        $totalVehicles = Vehicle::count();
        $totalParked = Vehicle::where("check_in_status", "Parked")->count();
        $totalLimit = Office::sum('vehicle_limit');
        $totalRemaining = $totalLimit - $totalParked;
        $recentInsideVehicles = Vehicle::where('check_in_status', 'Parked')
            ->whereNotNull('check_in_time')
            ->orderBy('check_in_time','desc')
            ->limit(5)
            // ->with('office')
            ->get();
            

        // Remaining offices
        $totalQrGenerated=QrCode::distinct("vehicle_id")->count();

        $recentOutsideVehicles = Vehicle::where('check_in_status', 'Not Parked')
            ->whereNotNull('check_out_time')
            ->orderBy('check_out_time','desc')
            ->limit(5)
            // ->with('office')
            ->get();
        // merge both into one vehicles collection
        $vehicles = $recentInsideVehicles->merge($recentOutsideVehicles);
        $search = $request->search;
        if ($request->ajax()) {
            if (!empty($search)) {
                // $vehicles = $vehicles->filter(function ($vehicle) use ($search) {
                //     return (stripos($vehicle->vehicle_number, $search) !== false) || (stripos($vehicle->office->office_name, $search) !== false);
                // });
                $vehicles = $vehicles->filter(function ($vehicle) use ($search) {
                    return (stripos($vehicle->vehicle_number, $search) !== false);
                });
                
            }
            $table = view('dashboard.partials.recent_check_in__table', compact('vehicles'))->render();
            return response()->json([
                'table' => $table,
            ]);
        }
        return view('dashboard.dashboard', compact('totalUsers', 'totalOffices', 'totalVehicles', 'totalParked', 'totalRemaining', 'vehicles','totalQrGenerated'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
