<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function index()
    {
        return view('buildings.building-management');
    }

    public function store(Request $request)
    {

        $request->validate([
            'building_name' => 'required',
            'building_address' => 'required',
            'building_images'=>'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        $building = new Building();
        if($request->hasFile('building_images')){
            $file = $request->file('building_images');
            $filename = $request->building_name . '_' . rand(0000, 9999) . '.' .$file->getClientOriginalExtension();
            $request->file('building_images')->storeAs('images/buildings', $filename, 'public');
            $building->building_image = $filename;
        }
        $building->building_name = $request->building_name;
        $building->building_address = $request->building_address;
        // dd($building);
        $building->save();

        // $total = $building->total();
        // $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
        return response()->json([
            // 'table' => $table,
            // 'total' => $total,
            // 'pagination' => $pagination,
            'message' => 'Building added successfully.',
        ]);
        // $vehicle->save();
        // $search = $request->search;
        // $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        // $curentPage = $request->input('currentPage', 1);
        // $status = $request->status;
        // // $vehicles = Vehicle::latest()->latest();
        // $selectedOffice = $request->select_office;
        // if ($selectedOffice) {
        //     $vehicles = $vehicles->where('office_id', $selectedOffice);
        // }
        // $vehicles = $vehicles->where('vehicle_number', 'like', "%$search%");
        // if ($status) {
        //     $vehicles = $vehicles->where('check_in_status', $status);
        // }
        // $lastPage = ceil($vehicles->count() / $itemsPerPage);
        // if ($curentPage > $lastPage) {
        //     $curentPage = $lastPage;
        // }
        // Paginator::currentPageResolver(function () use ($curentPage) {
        //     return $curentPage;
        // });
        // $vehicles = $vehicles->paginate($itemsPerPage);
        // $pagination = $vehicles->links('pagination::bootstrap-5')->render();

        // $total = $vehicles->total();
        // $table = view('vehicles.partials.vehicles_table', compact('vehicles'))->render();
        // return response()->json([
        //     'table' => $table,
        //     'total' => $total,
        //     'pagination' => $pagination,
        //     'message' => 'Vehicle added successfully.',
        // ]);
    }


}
