<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\QrCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
use Barryvdh\DomPDF\Facade\pdf as PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;
use TCPDF;
use TCPDF_FONTS;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {

        $offices = Office::latest()->get();
        $office = Office::find($request->id);
        $vehicleCount = Vehicle::latest()->when($office, function ($query) use ($office) {
            $query->where('office_id', $office->id);
        })->count();
        $qrs = Vehicle::when($office, function ($query) use ($office) {
            $query->where('office_id', $office->id);
        })->with('qrCode')->latest();
        $id = $request->id;

        // $qrs = $office->qrs()->latest();
        // Handle AJAX request
        if ($request->ajax()) {
            // Retrieve parameters from the request
            $itemsPerPage = $request->query('itemsPerPage', 100000);
            $filter = $request->filter;
            $search = $request->search;
            // Apply search filters
            if (!empty($search)) {
                $qrs = $qrs->where('vehicle_number', 'like', '%' . $search . '%');
            }
            if ($filter === 'hasQr') {
                $qrs = $qrs->whereHas('qrCode')->when($office, function ($query) use ($office) {
                    $query->where('office_id', $office->id);
                });
            } elseif ($filter === 'noQr') {
                $qrs = $qrs->doesntHave('qrCode')->when($office, function ($query) use ($office) {
                    $query->where('office_id', $office->id);
                });
            }
            // Paginate results
            $qrs = $qrs->paginate($itemsPerPage);
            $count = $qrs->total();

            // Return only the table HTML, not the entire layout
            $html = view("qr-codes.partials.qr_table", compact('qrs'))->render();

            // Send a JSON response with the table HTML and count
            return response()->json(['success' => true, 'html' => $html, 'count' => $count]);
        }
        // Server-rendered page with default pagination (30 items per page)
        $qrs = $qrs->paginate(30);
        return view('qr-codes.qr_code', compact("offices", "qrs", "vehicleCount",));

        // No office selected, return the page with the office selection dropdown
        return view('qr-codes.qr_code', compact("offices", "qrs", "vehicleCount"));
    }

    public function generateQrCode(Request $request)
    {
        $deselectedVehicles = json_decode($request->de_selected_vehicles, true);
        $selectedVehicles = json_decode($request->selected_vehicles, true);
        $selectedAll = $request->selected_all;
        $office = Office::find($request->officeId);
        if ($office) {
            $vehiclesWithQRCodeIds = QrCode::where('office_id', $office->id)
                ->pluck('vehicle_id')->toArray(); // Get all book IDs associated with QR codes for that office
        } else {
            $vehiclesWithQRCodeIds = QrCode::get()
                ->pluck('vehicle_id')->toArray(); // Get all book IDs associated with QR codes for that office
        }
        // Get all vehicles that do not have a QR code associated with that office
        if ($selectedAll === "true") {
            $excludedBookIds = array_merge($deselectedVehicles, $vehiclesWithQRCodeIds);
            $vehicles = Vehicle::whereNotIn('id', $excludedBookIds)
                ->when($office, function ($query) use ($office) {
                    $query->where('office_id', $office->id);
                })->get();
        } else {
            $vehicles = Vehicle::whereIn('id', $selectedVehicles)
                ->when($office, function ($query) use ($office) {
                    $query->where('office_id', $office->id);
                })
                ->get();
        }
        if ($vehicles->isEmpty()) {
            return back()->withInput()->with('noVehicle', "No vehicles found to generate QR.");
        }
        function generateUniqueCode()
        {
            do {
                // Generate a random 6-digit number
                $code = rand(100000, 999999);
                // Check if the code already exists in the database (assuming Vehicle as the model)
                $exists = QrCode::where('unique_code', $code)->exists();  // Change 'Vehicle' to your model

            } while ($exists);  // Repeat if the code exists

            return $code;
        }
        foreach ($vehicles as $vehicle) {
            $unique_code = generateUniqueCode();
            // if (extension_loaded('imagick')) {
            // $qrCodeSvg = FacadesQrCode::format('svg')->size(512)->backgroundColor(0, 0, 0, 0)->generate($url);
            $qrCodeSvg = FacadesQrCode::format('png')->size(512)->backgroundColor(255, 255, 255)->generate($unique_code);
            $randomName = uniqid("4");
            $sanitizedOfficeName = str_replace(' ', '_', $vehicle->office->office_name);
            $filePath = "qr-codes/{$sanitizedOfficeName}/{$vehicle->vehicle_number}_{$randomName}.png";
            Storage::disk('public')->put($filePath, $qrCodeSvg);
            QrCode::create([
                'vehicle_id' => $vehicle->id,
                'qr_code' => $filePath,
                "office_id" => $vehicle->office->id,
                'unique_code' => $unique_code,
            ]);
        }
        $totalcount = $vehicles->count();
        return back()->with('Success', "total $totalcount QR codes generated  successfully.");
    }
    public function downloadQrCode(Request $request, $qrId = null)
    {
        if ($qrId) {
            $qrCode = QrCode::find($qrId);
            $officeId = $qrCode->office_id;
        }
        $office = Office::find($request->officeId);
        if ($qrId) {
            $qrCodes = QrCode::where('id', $qrId)->with("vehicle")->get();
        } else {
          
                $qrCodes = QrCode::when($office,function($query) use($office){
                    $query->where('office_id',$office->id);
                })->with('vehicle')->get();
        }
        if ($qrCodes->isEmpty()) {
            return back()->withInput()->with('noBrandedBook', "No vehicles found to download QR.");
        }
        return view('qr-codes.qr_download_qr', compact("qrCodes"));
    }
}
