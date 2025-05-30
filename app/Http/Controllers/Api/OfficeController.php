<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\QrCode;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    //
    public function officeVehicleDetails(Request $request)
    {
        // Your logic to get office and vehicle details
        // For example:
        // ([
        //     'unique_code' => 'required|integer|exists:offices,id',
        // ]);
        // use validatior make 
        $validator = Validator::make($request->all(), [
            'unique_code' => 'required|integer|exists:qr_codes,unique_code',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        // Assuming you have a model named QrCode and a relationship with Office


        $unique_code = $request->input('unique_code');
        // Assuming you have a model named Office and a relationship with Vehicle
        $qrCode = QrCode::where('unique_code', $unique_code)->first();
        if (!$qrCode) {
            return response()->json(['error' => 'QR code not found'], 404);
        }
        $officeId = $qrCode->office_id;
        $office = \App\Models\Office::find($officeId);
        $space_occupied = Vehicle::where('check_in_status', 'Parked')->count();
        $space_left = $office->vehicle_limit - $space_occupied;
        $office->space_occupied = $space_occupied;
        $office->space_left = $space_left;
        $office = $office->toArray();
        $vehicle = Vehicle::find($qrCode->vehicle_id)->toArray();
        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }
        $data = array_merge($office, $vehicle);
        return response()->json(
            [
                "message" => "Office and Vehicle details fetched successfully",
                "data" => $data,
                "success" => 1,
            ]
        );
    }
    public function officeVehicleList(Request $request)
    {
        // Your logic to get office and vehicle list
        // For example:
        // api details
        // -> request fields:- id, api_token, office_no.
        // -> response field:- office no, office_name, office_owner_name, office_owner_email, office_owner_phone_no, vehicle_limit, space_occupied, space_left,
        // [vehicle_no, vehicle_owner_phone_no, check_in_status, check_in_time, check_out_time].
        $validator = Validator::make($request->all(), [
            'office_no' => 'required|exists:offices,office_number',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $office_no = $request->input('office_no');
        // Assuming you have a model named Office and a relationship with Vehicle
        $office = \App\Models\Office::where('office_number', $office_no)->first();
        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }
        $vehicles = $office->vehicles()->get();
        $space_occupied = Vehicle::where('check_in_status', 'Parked')->count();
        $space_left = $office->vehicle_limit - $space_occupied;
        $office->space_occupied = $space_occupied;
        $office->space_left = $space_left;
        $office = $office->toArray();
        $office["vehicles"]=$vehicles->toArray();
        // $data = array_merge($office, $vehicles->toArray());
        return response()->json(
            [
                "message" => "Office and Vehicles list fetched successfully",
                "data" => $office,
                "success" => 1,
            ]
        );
    }
    public function officeList(Request $request)
    {
        // Your logic to get office list
        // For example:
        // api details
        // -> request fields:- id, api_token, search, itemsPerPage, currentPage.
        // -> response field:- office_no, office_name, office_owner_name, office_owner_email, office_owner_phone_no, vehicle_limit, space_occupied, space_left,
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $curentPage = $request->input('currentPage', 1);

        $offices = Office::latest()->pluck("office_number")->toArray();
        return response()->json([
            'success' => 1,
            'data' => $offices,
            'message' => 'Office list fetched successfully',
        ]);
    }
}
