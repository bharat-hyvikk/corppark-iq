<table class="table align-items-center mb-0">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                Office Name
            </th>
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
            
            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                Action
            </th>
        </tr>
    </thead>

    <tbody id="vehicle_table_body">
        @foreach ($vehicles as $vehicle)
            <tr id="vehicle-{{ $vehicle->id }}">
                <td>
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
                        {{ $vehicle->vehicle_number}}
                    </p>
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
                        {{ $vehicle->check_in_time??"NA" }}
                    </p>
                </td>
                <td class="align-middle text-start text-sm">
                    <p class="text-sm text-dark font-weight-semibold mb-0 email ps-3">
                        {{ $vehicle->check_out_time??"NA" }}
                    </p>
                </td>
               
                <td class="text-center align-middle">
                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs edit-item"
                        data-id="{{ $vehicle->id }}" data-bs-toggle="tooltip" data-bs-title="Edit Vehicle"
                        data-bs-modal="#editModal" id="editVehicleBtn">
                        <svg width="17" height="17" viewBox="0 0 15 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z"
                                fill="#64748B" />
                        </svg>
                    </a>

                    <a href="javascript:;" data-id="{{ $vehicle->id }}"
                        class="text-secondary font-weight-bold text-xs mx-2 delete-item" data-bs-toggle="tooltip"
                        data-bs-title="Delete Vehicle" data-bs-toggle="modal" data-bs-target="#deleteaddModal"
                        data-name="{{ $vehicle->vehicle_number }}">
                        <i class="fa-solid fa-trash" style="font-size: 17px"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="ms-auto mt-2 fw-bold" id="paginationContainer">
    {{ $vehicles->links('pagination::bootstrap-5') }}
</div>
