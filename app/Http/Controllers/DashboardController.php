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

        $totalUsers = User::where("user_type", "0")->count();
        $isAdmin = Auth::user()->isAdmin;
        $totalOffices = Office::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->offices->pluck('id'));
        })->count();
        $totalBuildings = Building::count();

        $totalVehicles = Vehicle::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->count();
        $totalParked = Vehicle::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where("check_in_status", "Parked")->count();
        $totalLimit = Office::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->offices->pluck('id'));
        })->sum('vehicle_limit');
        $totalRemaining = $totalLimit - $totalParked;
        $recentInsideVehicles = Vehicle::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where('check_in_status', 'Parked')
            ->whereNotNull('check_in_time')
            ->orderBy('check_in_time', 'desc')
            ->limit(5)
            // ->with('office')
            ->get();


        // Remaining offices
        $totalQrGenerated = QrCode::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('office_id', $building->offices->pluck("id"));
        })->distinct("vehicle_id")->count();
       

        $recentOutsideVehicles = Vehicle::when(!$isAdmin, function ($query) {
            $building = Building::find(Auth::user()->building_id);
            $query->whereIn('id', $building->vehicles->pluck("id"));
        })->where('check_in_status', 'Not Parked')
            ->whereNotNull('check_out_time')
            ->orderBy('check_out_time', 'desc')
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
                    return stripos($vehicle->vehicle_number, $search) !== false;
                });
            }
            $table = view('dashboard.partials.recent_check_in__table', compact('vehicles'))->render();
            return response()->json([
                'table' => $table,
            ]);
        }
        return view('dashboard.dashboard', compact('totalUsers', 'totalOffices', 'totalVehicles', 'totalParked', 'totalRemaining', 'vehicles', 'totalQrGenerated', 'totalBuildings'));
    }
}
