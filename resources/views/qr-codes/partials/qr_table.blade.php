<table class="table align-items-center mb-0">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-secondary text-xs font-weight-semibold opacity-7"> Select vehicle</th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">Vehicle Number
            </th>
            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
              View QR </th>
            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                Download QR</th>
        </tr>
    </thead>
    <tbody id="qr_table_body">
        @if($qrs)
        @foreach ($qrs as $qrcode)
            <tr id="vehicle-{{ $qrcode->id }}">
                @if ($qrcode->qrCode)
                    <td>
                        <div class="d-flex px-3">
                            <input type="checkbox" name="select_vehicle" id="selected_vehicle__{{ $qrcode->id }}"
                                disabled>
                        </div>
                    </td>
                @else
                    <td>
                        <div class="d-flex px-3">
                            <input type="checkbox" name="select_vehicle" id="selected_vehicle_{{ $qrcode->id }}"
                                value="{{ $qrcode->id }}">
                        </div>
                    </td>
                @endif
                <td>
                    <div class="d-flex px-3">
                        <h6
                            class="mb-0 text-sm font-weight-semibold text-wrap capitalize-first-letter qrcode-title qrcode-name">
                            {{ $qrcode->vehicle_number }}
                        </h6>
                    </div>
                </td>
                <td class="text-center align-middle">
                    @if ($qrcode->qrCode)
                        <i class="fa-solid fa-file-image media-icon cursor-pointer" style="font-size: 25px;"
                            data-media-src="{{ Storage::disk("public")->url($qrcode->qrCode->qr_code) }}" data-id="{{ $qrcode->id }}"
                            data-vehicle-number="{{ $qrcode->vehicle_number }}" data-bs-toggle="tooltip"
                            data-bs-title="View QR"></i>
                    @else
                        <img src="{{ asset('assets/img/Icon SVG-04 1 (1).svg') }}" width="20px" height="27px"
                            data-bs-toggle="tooltip" data-bs-title="QR not available" style="cursor: not-allowed;">
                    @endif
                </td>
                <td class="text-center align-middle">

                    @if ($qrcode->qrCode)

                        <a href="{{route('qrcode.download', $qrcode->qrCode->id)}}"
                            class="text-secondary font-weight-bold text-xs mx-2" data-bs-toggle="tooltip"
                            data-bs-title="Download QR" >
                            <i class="fa-sharp fa-solid fa-download" style="font-size:17px;"></i>
                        </a>
                    @else
                        <img src="{{ asset('assets/img/Icon SVG-03 1 (1).svg') }}" width="20px" height="15px"
                            data-bs-toggle="tooltip" data-bs-title="QR not available" style="cursor: not-allowed;">
                    @endif
                </td>
                {{-- <td class="text-center align-middle">
                    @if ($qrcode->qrCode)
                        <a href="{{ Storage::disk("public")->url($qrcode->qrCode->qr_code) }}"
                            class="text-secondary font-weight-bold text-xs mx-2" data-bs-toggle="tooltip"
                            data-bs-title="Download QR" download>
                            <i class="fa-sharp fa-solid fa-download" style="font-size:17px;"></i>
                        </a>
                    @else
                        <img src="{{ asset('assets/img/Icon SVG-03 1 (1).svg') }}" width="20px" height="15px"
                            data-bs-toggle="tooltip" data-bs-title="QR not available" style="cursor: not-allowed;">
                    @endif
                </td> --}}
            </tr>
        @endforeach
        @endif
    </tbody>
    {{-- <tbody id="qr_table_body">
        @foreach ($Qr as $vehicle) 
        <tr id="vehicle-{{ $vehicle->id }}">
            <td>
                <div class="d-flex px-3">
                    <h6 class="mb-0 text-sm font-weight-semibold text-wrap capitalize-first-letter qrcode-title qrcode-name">
                        {{ $vehicle->name }} 
                    </h6>
                </div>
            </td>
            <td class="text-center align-middle">
                @if ($vehicle->qr) 
                    <i class="fa-solid fa-file-image media-icon cursor-pointer" style="font-size: 25px;"
                        data-media-src="{{ Storage::url($vehicle->qr->qr_code) }}"
                        data-id="{{ $vehicle->qr->id }}" data-bs-toggle="tooltip" data-bs-title="View QR"></i>
                @else
                    <i class="fa-solid fa-file-excel" data-bs-toggle="tooltip" data-bs-title="QR not available" style="cursor: not-allowed; font-size: 25px; color: #64748b;"></i> 
                @endif
            </td>
            <td class="text-center align-middle"> 
                @if ($vehicle->qr) 
                    <a href="{{ Storage::url($vehicle->qr->qr_code) }}" 
                        class="text-secondary font-weight-bold text-xs mx-2" 
                        data-bs-toggle="tooltip" data-bs-title="Download QR" 
                        download>
                        <i class="fa-sharp fa-solid fa-download" style="font-size:17px;"></i>
                    </a>
                @else
                    <i class="fa-solid fa-file-excel" data-bs-toggle="tooltip" data-bs-title="QR not available" style="cursor: not-allowed; font-size: 25px; color: #64748b;"></i>    
                @endif
            </td>
        </tr>
        @endforeach
    </tbody> --}}
</table>
<div class="ms-auto mt-2 fw-bold" id="paginationContainer">
    @if ($qrs)
        {{ $qrs->links('pagination::bootstrap-5') }}
    @endif
</div>
