<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\InvoiceMgmt;
use App\Models\Office;
use App\Models\QrCode;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->building_id) {
            $building = Building::find($request->building_id);
        } else if (!Auth::user()->isAdmin) {
            $building = Building::find(Auth::user()->building_id);
        } else {
            $building = null;
        }

        $isAdmin = Auth::user()->isAdmin;
        // if ($isAdmin) {
        //     $totalUsers = User::where("user_type", "!=", "1")->count();
        // } else {
        //     $totalUsers = User::where("user_type", "0")->count();
        // }
        $totalUsers = User::when($building, function ($query) use ($building) {
            $query->where('building_id', $building->id);
        })->whereNotNull("building_id")->count();





        $totalOffices = Office::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->offices->pluck('id'));
        })->count();
        $totalBuildings = Building::latest()->get();

        $totalVehicles = Vehicle::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->count();
        $totalParked = Vehicle::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where("check_in_status", "Parked")->count();
        $totalLimit = Office::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->offices->pluck('id'));
        })->sum('vehicle_limit');
        $totalRemaining = $totalLimit - $totalParked;
        $recentInsideVehicles = Vehicle::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where('check_in_status', 'Parked')
            ->whereNotNull('check_in_time')
            ->orderBy('check_in_time', 'desc')
            ->limit(5)
            // ->with('office')
            ->get();


        // Remaining offices
        $totalQrGenerated = QrCode::when($building, function ($query) use ($building) {
            $query->whereIn('office_id', $building->offices->pluck("id"));
        })->distinct("vehicle_id")->count();


        $recentOutsideVehicles = Vehicle::when($building, function ($query) use ($building) {
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where('check_in_status', 'Not Parked')
            ->whereNotNull('check_out_time')
            ->orderBy('check_out_time', 'desc')
            ->limit(5)
            // ->with('office')
            ->get();
        $vehicles = $recentInsideVehicles->merge($recentOutsideVehicles);
        $search = $request->search;
        $selectedBuilding = $building;

        if ($request->ajax()) {
            $dashboardCount = view('dashboard.partials.dashboard_count', compact('totalUsers', 'totalOffices', 'totalVehicles', 'totalParked', 'totalRemaining', 'totalQrGenerated', 'totalBuildings', 'selectedBuilding'))->render();
            if (!empty($search)) {
                $vehicles = $vehicles->filter(function ($vehicle) use ($search) {
                    return stripos($vehicle->vehicle_number, $search) !== false;
                });
            }
            $table = view('dashboard.partials.recent_check_in__table', compact('vehicles'))->render();
            return response()->json([
                'table' => $table,
                'dashboardCount' => $dashboardCount,
                'totalQrGenerated' => $totalQrGenerated,
                'totalVehicles' => $totalVehicles,
                'selectedBuilding' => $selectedBuilding,
            ]);
        }
        return view('dashboard.dashboard', compact('totalUsers', 'totalOffices', 'totalVehicles', 'totalParked', 'totalRemaining', 'vehicles', 'totalQrGenerated', 'totalBuildings', 'selectedBuilding'));
    }
}
