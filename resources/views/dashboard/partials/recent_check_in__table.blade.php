<table class="table align-items-center mb-0">
    <thead class="bg-gray-100">
        <tr>
            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Office Name
            </th> --}}
            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Vehicle Number
            </th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Owner Number
            </th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                Check In Status
            </th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Check In Time
            </th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Check Out Time
            </th>
        </tr>
    </thead>
    <tbody id="vehicle_table_body">
        @foreach ($vehicles as $vehicle)
            <tr id="vehicle-{{ $vehicle->id }}">
                {{-- <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center ms-1">
                            <h6 class="mb-0 text-sm font-weight-semibold name">
                                {{ $vehicle->office->office_name }}
                            </h6>
                        </div>
                    </div>
                </td>

                <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 email ps-3">
                        {{ $vehicle->vehicle_number }}
                    </p>
                </td> --}}
                                <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center ms-1">
                            <h6 class="mb-0 text-sm font-weight-semibold name">
                                {{ $vehicle->vehicle_number }}
                            </h6>
                        </div>
                    </div>
                </td>

                <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 email ps-3">
                        {{ $vehicle->owner_phone }}
                    </p>
                </td>
                {{-- <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 operating_type ps-2">
                        {{ $vehicle->check_in_status }}
                    </p>
                </td> --}}
                 <td class="align-middle text-start text-sm">
                    @if ($vehicle->check_in_status == "Not Parked")
                        <span
                            class="badge badge-sm border border-danger text-danger bg-danger w-60">{{ $vehicle->check_in_status  }}</span>
                    @else
                        <span
                            class="badge badge-sm border border-success text-success bg-success w-60">{{ $vehicle->check_in_status }}</span>
                    @endif
                </td>
                <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 email ps-3">
                        {{ $vehicle->check_in_time ?? 'NA' }}
                    </p>
                </td>
                <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 email ps-3">
                        {{ $vehicle->check_out_time ?? 'NA' }}
                    </p>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
