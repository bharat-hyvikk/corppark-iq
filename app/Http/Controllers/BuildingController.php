<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $building = Building::latest();
        if ($request->ajax()) {
            // dd('1');
            $search = $request->search;
            $building = $building->where('building_name', 'like', "%$search%");
            // dd($building);
            $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
            $curentPage = $request->input('page', 1);
            Paginator::currentPageResolver(function () use ($curentPage) {
                return $curentPage;
            });
            $building = $building->paginate($itemsPerPage);
            $pagination = $building->links('pagination::bootstrap-5')->render();
            $total = $building->total();
            $table = view('buildings.partials.buildings_table', compact('building'))->render();
            return response()->json([
                'table' => $table,
                'total' => $total,
                'pagination' => $pagination,
            ]);
        }
        $building = $building->paginate(30);
        return view('buildings.building-management', compact('building'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'building_name' => 'required',
            'building_address' => 'required',
            'building_images'=>'required|mimes:png,jpg,jpeg|max:20480',
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
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $building = Building::latest();
        $lastPage = ceil($building->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $building = $building->paginate($itemsPerPage);
        $pagination = $building->links('pagination::bootstrap-5')->render();

        $total = $building->total();
        $table = view('buildings.partials.buildings_table', compact('building'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            // 'pagination' => $pagination,
            'message' => 'Building added successfully.',
        ]);

    }

    public function edit(Request $request)
    {
        $building = Building::find($request->id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }
        return response()->json(['building' => $building]);
    }

    public function update(Request $request){
        $request->validate([
            'building_name' => 'required',
            'building_address' => 'required',
            'building_images'=>'mimes:png,jpg,jpeg|max:20480',
        ]);
        $building = Building::find($request->id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }
        $building->building_name = $request->building_name;
        $building->building_address = $request->building_address;
        if($request->hasFile('building_images')){
            Storage::disk('public')->delete('images/buildings/'.$building->building_image);
            $file = $request->file('building_images');
            $filename = $request->building_name . '_' . rand(0000, 9999) . '.' .$file->getClientOriginalExtension();
            $request->file('building_images')->storeAs('images/buildings', $filename, 'public');
            $building->building_image = $filename;
        }
        $building->save();
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $building = Building::latest();
        $lastPage = ceil($building->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $building = $building->paginate($itemsPerPage);
        $pagination = $building->links('pagination::bootstrap-5')->render();

        $total = $building->total();
        $table = view('buildings.partials.buildings_table', compact('building'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            // 'pagination' => $pagination,
            'message' => 'Building added successfully.',
        ]);
    }
    public function destroy(Request $request){
        //
        $building = Building::find($request->id);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }
        $building->delete();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('page', 1);
        $building = Building::latest();
        if ($request->search) {
            $building = $building->where('building_name', 'like', "%$search%");
        }
        $lastPage = ceil($building->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $building = $building->paginate($itemsPerPage);
        $pagination = $building->links('pagination::bootstrap-5')->render();
        $total = $building->total();
        $table = view('buildings.partials.buildings_table', compact('building'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            // 'pagination' => $pagination,
            'message' => 'Building added successfully.',
        ]);
    }


}
