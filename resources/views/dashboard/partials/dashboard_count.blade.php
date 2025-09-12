                <div class="col-xl-2 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fa-sharp fa-solid fa-users" aria-hidden="true"
                                    style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">
                                            Users
                                        </p>
                                        <h4 class="mb-2 font-weight-bold">
                                            {{ $totalUsers }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->isAdmin && is_null($selectedBuilding))
                    <div class="col-xl-2 col-sm-6 mb-xl-0">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-body text-start p-3 w-100">
                                <div
                                    class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                    <i class="fa-sharp fa-solid fas far fas fa-briefcase" aria-hidden="true"
                                        style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="w-100">
                                            <p class="text-sm text-secondary mb-1">
                                                Buildings
                                            </p>
                                            <h4 class="mb-2 font-weight-bold">
                                                {{ $totalBuildings->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-xl-2 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fa-sharp fa-solid fas far fas fa-briefcase" aria-hidden="true"
                                    style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">
                                            Offices
                                        </p>
                                        <h4 class="mb-2 font-weight-bold">
                                            {{ $totalOffices }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fa-sharp fa-solid far fas fa-car-side" aria-hidden="true"
                                    style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-secondary mb-1" style="font-size:13px">
                                            Vehicles
                                        </p>
                                        <h4 class="mb-2 font-weight-bold">{{ $totalVehicles }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fa-sharp fa-solid fas fa-square-parking" aria-hidden="true"
                                    style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">
                                            Total Parked
                                        </p>
                                        <h4 class="mb-2 font-weight-bold">
                                            {{ $totalParked }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fa-sharp fa-solid far fa-square-minus" aria-hidden="true"
                                    style="
                                        font-size: 16px;
                                        colur: #fff;
                                        background-color: #1e293b !important;
                                        opacity: 1;
                                    "></i>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">
                                            Total Remaining
                                        </p>
                                        <h4 class="mb-2 font-weight-bold">
                                            {{ $totalRemaining }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
