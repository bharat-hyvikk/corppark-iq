<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceMgmt;
use App\Models\Office;
use App\Models\QrCode;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class  VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::latest();
        $offices = Office::latest()->get();
        $completedOffices = DB::table('offices')
            ->join('vehicles', 'offices.id', '=', 'vehicles.office_id')
            ->leftJoin('qr_codes', 'vehicles.id', '=', 'qr_codes.vehicle_id')
            ->select('offices.id')
            ->groupBy('offices.id')
            ->havingRaw('COUNT(vehicles.id) = COUNT(qr_codes.id)')
            ->pluck('offices.id'); // get matching office IDs

        $completedCount = $completedOffices->count();

        // Total offices
        $totalOffices = \App\Models\Office::count();

        // Remaining offices
        $remainingCount = $totalOffices - $completedCount;
        if ($request->ajax()) {
            $search = $request->search;
            $status = $request->status;
            $vehicles = $vehicles->where('vehicle_number', 'like', "%$search%");
            $selectedOffice = $request->select_office;
            if ($selectedOffice) {
                $vehicles = $vehicles->where('office_id', $selectedOffice);
            }
            if ($status) {
                $vehicles = $vehicles->where('check_in_status', $status);
            }
            $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
            $curentPage = $request->input('page', 1);

            Paginator::currentPageResolver(function () use ($curentPage) {
                return $curentPage;
            });
            $vehicles = $vehicles->paginate($itemsPerPage);
            $pagination = $vehicles->links('pagination::bootstrap-5')->render();
            $total = $vehicles->total();
            $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
            return response()->json([
                'table' => $table,
                'total' => $total,
                'pagination' => $pagination,
            ]);
        }
        $vehicles = $vehicles->paginate(30);
        return view('vehicles.vehicle-management', compact('vehicles', 'offices'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the request data
        // : Vehicles can be registered only if the office limit is not exceeded.
        $office = Office::find($request->office_id);
       

        $request->validate(
            [
                'vehicle_number' => 'required|string|max:255|unique:vehicles,vehicle_number',
                'office_id' => [
                    "required",
                    "exists:offices,id",
                    function ($attribute, $value, $fail) use ($office) {
                        if ($office->vehicles()->count() >= $office->vehicle_limit) {
                            $fail('The office has reached its vehicle limit.');
                        }
                    }
                ],
                'phone' => 'required|numeric|digits:10'
            ],
            [
                
            ]
        );
        // Create a new vehicle

        $vehicle = new Vehicle();
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->office_id = $request->office_id;
        $vehicle->owner_phone = $request->phone;
        $vehicle->check_in_status = 'Not Parked';
        $vehicle->check_in_time = null;
        $vehicle->check_out_time = null;
        $vehicle->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        $vehicles = Vehicle::latest()->latest();
        $selectedOffice = $request->select_office;
        if ($selectedOffice) {
            $vehicles = $vehicles->where('office_id', $selectedOffice);
        }
        $vehicles = $vehicles->where('vehicle_number', 'like', "%$search%");
        if ($status) {
            $vehicles = $vehicles->where('check_in_status', $status);
        }
        $lastPage = ceil($vehicles->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $vehicles = $vehicles->paginate($itemsPerPage);
        $pagination = $vehicles->links('pagination::bootstrap-5')->render();

        $total = $vehicles->total();
        $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Vehicle added successfully.',
        ]);
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
    public function edit(Request $request)
    {
        //
        $vehicle = Vehicle::find($request->id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        return response()->json(['vehicle' => $vehicle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $vehicle = Vehicle::find($request->id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        $office = Office::find($request->office_id);
        $request->validate(
            [
                'vehicle_number' => 'required|string|max:255|unique:vehicles,vehicle_number,' . $request->id,
                'office_id' => [
                    "required",
                    "exists:offices,id",
                    function ($attribute, $value, $fail) use ($office, $vehicle) {
                        if ($office->vehicles()->count() >= $office->vehicle_limit && $office->id != $vehicle->office_id) {
                            $fail('The office has reached its vehicle limit.');
                        }
                    }
                ],
                'phone' => 'required|numeric|digits:10'
            ],
            [
                'vehicle_number.unique' => 'The vehicle number is already in use.',
                'phone.unique' => 'The phone number is already in use.',
                'office_id.exists' => 'The selected office is invalid.',
                'phone.digits' => 'The Owner phone number must be 10 digits.',
                'phone.numeric' => 'The Owner phone number must be a number.',
                'vehicle_number.required' => 'The vehicle number is required.',
            ]
        );
        // Create a new vehicle
        $vehicle = Vehicle::find($request->id);
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->office_id = $request->office_id;
        $vehicle->owner_phone = $request->phone;
        $vehicle->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        $vehicles = Vehicle::latest();
        $selectedOffice = $request->select_office;
        if ($selectedOffice) {
            $vehicles = $vehicles->where('office_id', $selectedOffice);
        }
        if ($status) {
            $vehicles = $vehicles->where('check_in_status', $status);
        }
        if ($request->search) {
            $vehicles = $vehicles->where('vehicle_number', 'like', "%$search%");
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $vehicles = $vehicles->paginate($itemsPerPage);
        $pagination = $vehicles->links('pagination::bootstrap-5')->render();

        $total = $vehicles->total();
        $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Vehicle updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $vehicle = Vehicle::find($request->id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        $vehicle->delete();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('page', 1);
        $vehicles = Vehicle::latest();
        $selectedOffice = $request->select_office;
        if ($selectedOffice) {
            $vehicles = $vehicles->where('office_id', $selectedOffice);
        }
        if ($request->search) {
            $vehicles = $vehicles->where('vehicle_number', 'like', "%$search%");
        }
        $status = $request->status;
        if ($status) {
            $vehicles = $vehicles->where('check_in_status', $status);
        }
        $lastPage = ceil($vehicles->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $vehicles = $vehicles->paginate($itemsPerPage);
        $pagination = $vehicles->links('pagination::bootstrap-5')->render();

        $total = $vehicles->total();
        $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Vehicle deleted successfully.',
        ]);
    }
}
