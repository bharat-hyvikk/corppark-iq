<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\InvoiceMgmt;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class  OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if (Auth::user()->user_type == "1") {
            $offices = Office::latest()->withCount('vehicles');
        } else {
            $offices = Office::latest()->withCount('vehicles')->where('building_id', Auth::user()->building_id);
        }


        $buildings = Building::latest()->get();
        if ($request->ajax()) {
            $search = $request->search;
            $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
            $curentPage = $request->input('page', 1);
            $offices = $offices->where('office_name', 'like', "%$search%")->orWhere('owner_name', 'like', "%$search%");
            Paginator::currentPageResolver(function () use ($curentPage) {
                return $curentPage;
            });
            $offices = $offices->paginate($itemsPerPage);
            $pagination = $offices->links('pagination::bootstrap-5')->render();
            $total = $offices->total();
            $table = view('offices.partials.offices_table', compact('offices'))->render();
            return response()->json([
                'table' => $table,
                'total' => $total,
                'pagination' => $pagination,
            ]);
        }
        $offices = $offices->paginate(30);
        return view('offices.office-management', compact('offices', 'buildings'));
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
        if (Auth::user()->user_type == 2) {
            $request->merge(['building' => Auth::user()->building_id]);
        }
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'office_number' => 'required|string|max:255',
                'email' => 'required|email|unique:offices,owner_email',
                'phone' => 'required|numeric|digits:10|unique:offices,owner_phone_number',
                'vehicle_limit' => 'required|integer|min:1',
            ],
            [
                'phone.unique' => 'The phone number is already in use.',
                'email.unique' => 'The email address is already in use.',
                'vehicle_limit.min' => 'The vehicle limit must be at least 1.',
                'vehicle_limit.integer' => 'The vehicle limit must be an integer.',
                'vehicle_limit.required' => 'The vehicle limit field is required.',
                'name.required' => 'The office name field is required.',
                'owner_name.required' => 'The owner name field is required.',
                'office_number.required' => 'The office number field is required.',
                'email.required' => 'The owner email field is required.',
                'phone.required' => 'The owner phone number field is required.',

            ]
        );
        // Create a new user

        $office = new Office();
        $office->office_name = $request->name;
        $office->owner_name = $request->owner_name;
        $office->owner_email = $request->email;
        $office->owner_phone_number = $request->phone;
        $office->vehicle_limit = $request->vehicle_limit;
        $office->office_number = $request->office_number;
        if (Auth::user()->user_type == 1) {
            $office->building_id = $request->building;
        } else {
            $office->building_id = Auth::user()->building_id;
        }
        // dd($office);
        $office->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        if (Auth::user()->user_type == "1") {
            $offices = Office::latest()->withCount('vehicles');
        } else {
            $offices = Office::latest()->withCount('vehicles')->where('building_id', Auth::user()->building_id);
        }
        $offices = $offices->where('office_name', 'like', "%$search%")->orWhere('owner_name', 'like', "%$search%");
        $lastPage = ceil($offices->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $offices = $offices->paginate($itemsPerPage);
        $pagination = $offices->links('pagination::bootstrap-5')->render();

        $total = $offices->total();
        $table = view('offices.partials.offices_table', compact('offices'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Office added successfully.',
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
        $office = Office::find($request->id);
        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }
        return response()->json(['Office' => $office]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate data just like in store method
        if (Auth::user()->user_type == 2) {
            $request->merge(['building' => Auth::user()->building_id]);
        }
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'office_number' => 'required|string|max:255',
                'email' => 'required|email|unique:offices,owner_email,' . $request->id,
                'phone' => 'required|numeric|digits:10|unique:offices,owner_phone_number,' . $request->id,
                'vehicle_limit' => 'required|integer|min:1',
            ],
            [
                'phone.unique' => 'The phone number is already in use.',
                'email.unique' => 'The email address is already in use.',
                'vehicle_
limit.min' => 'The vehicle limit must be at least 1.',
                'vehicle_limit.integer' => 'The vehicle limit must be an integer.',
                'vehicle_limit.required' => 'The vehicle limit field is required.',
                'name.required' => 'The office name field is required.',
                'owner_name.required' => 'The owner name field is required.',
                'office_number.required' => 'The office number field is required.',
                'email.required' => 'The owner email field is required.',
                'phone.required' => 'The owner phone number field is required.',

            ]
        );
        // Create a new user
        $office = Office::find($request->id);
        $office->office_name = $request->name;
        $office->owner_name = $request->owner_name;
        $office->owner_email = $request->email;
        $office->owner_phone_number = $request->phone;
        $office->vehicle_limit = $request->vehicle_limit;
        $office->office_number = $request->office_number;
        if (Auth::user()->user_type == 1) {
            $office->building_id = $request->building;
        } else {
            $office->building_id = Auth::user()->building_id;
        }
        $office->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        if (Auth::user()->user_type == "1") {
            $offices = Office::latest()->withCount('vehicles');
        } else {
            $offices = Office::latest()->withCount('vehicles')->where('building_id', Auth::user()->building_id);
        }
        if ($request->search) {
            $offices->where('office_name', 'like', "%$search%")->orWhere('owner_name', 'like', "%$search%");
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $offices = $offices->paginate($itemsPerPage);
        $pagination = $offices->links('pagination::bootstrap-5')->render();

        $total = $offices->total();
        $table = view('offices.partials.offices_table', compact('offices'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Office updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $office = Office::find($request->id);
        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }
        $vehicles = $office->vehicles;
        if ($vehicles->count() > 0) {
            return response()->json(['error' => 'Cannot delete office with vehicles.'], 400);
        }
        $office->delete();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('page', 1);
        $offices = Office::latest()->latest();
        if ($request->search) {
            $offices->where('office_name', 'like', "%$search%")->orWhere('owner_name', 'like', "%$search%");
        }
        $lastPage = ceil($offices->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $offices = $offices->paginate($itemsPerPage);
        $pagination = $offices->links('pagination::bootstrap-5')->render();

        $total = $offices->total();
        $table = view('offices.partials.offices_table', compact('offices'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'Office deleted successfully.',
        ]);
    }
}
