<x-app-layout>
    <main class="main-content d-flex flex-column position-relative border-radius-lg ps min-vh-100">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName="Dashboard" />
        </div>
        <div class="container-fluid py-4 px-5 flex-grow-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-1 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">
                                Welcome {{ auth()->user()->name }}
                            </h3>
                            @if (auth()->user()->isAdmin)
                                <p>
                                    See information about Users,Buildings,Offices,Vehicles and QR related Modules.
                                </p>
                            @else
                                <p>
                                    See information about Users,Offices,Vehicles and QR related Modules.
                                </p>
                            @endif
                        </div>
                        @if (auth()->user()->isAdmin)
                            <div class="ms-auto w-20">
                                <label for="building" class="form-label text-lg">Filter by Building</label>
                                <select name="buildings" id="select_building" class="form-select form-select-md"
                                    onchange="filterTable()">
                                    <option value="">Select Building</option>
                                    @foreach ($totalBuildings as $building)
                                        <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="row mt-5 justify-content-between" id="dashboardCounts">
                @include('dashboard.partials.dashboard_count')
            </div>
            <div class="row my-4">
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Vehicles and their QR Code Analysis</h6>
                            <p class="text-sm">Below are the details of total no of Vehicles With Generated QR Code and
                                total No of vehicles Without QR Code </p>

                        </div>
                        <div class="card-body py-3">
                            <div class="chart mb-2">
                                <canvas id="officesQRChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-6">
                    <div class="card shadow-xs borde h-100">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Recent Vehicles Check In</h6>
                                    <p class="text-sm mb-sm-0 mb-2">Below are the details of the recent Vehicles Check
                                        In</p>
                                    </p>
                                </div>
                                <div class="input-group w-sm-25 ms-auto">
                                    <span class="input-group-text text-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search" id="search">
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column  px-0 py-3 h-100">
                            <div class="table-responsive p-0 overflow-auto flex-grow-1" id="contentTable">
                                @include('dashboard.partials.recent_check_in__table', [
                                    'vehicles' => $vehicles,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
<script>
    let timeout;
    $("#search").on("keyup", function() {
        console.log("search");
        timeout = setTimeout(filterTable, 1000);
    });

    function filterTable($page = 1) {
        let searchInput = $('#search').val().toLowerCase();
        let selectedBuilding = $("#select_building").val();
        $.ajax({
            type: "GET",
            url: "dashboard",
            data: {
                search: searchInput,
            },
            success: function(response) {
                $('#contentTable').html(response.table);
                $('#dashboardCounts').html(response.dashboardCount);
                //console.log(selectedBuilding)
                if (selectedBuilding) {
                    initCharts(response.totalVehicles, response.totalQrGenerated, response
                        .selectedBuilding);
                } else if (window.officesQRChartInstance.ctx.canvas.buildingId) {
                    initCharts(response.totalVehicles, response.totalQrGenerated);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    }
    let chart = null;

    function initCharts(totalVehicles, totalQrGenerated, selectedBuilding = null) {
        const ctx1 = document.getElementById('officesQRChart');
        if (selectedBuilding && ctx1.buildingId == selectedBuilding.id) {
            return;
        }
        if (selectedBuilding) {
            ctx1.buildingId = selectedBuilding.id;
        } else {
            delete ctx1.buildingId;
        }
        if (ctx1) {
            // destroy old chart if exists (important to avoid duplicates)
            if (window.officesQRChartInstance) {
                window.officesQRChartInstance.destroy();

            }
            window.officesQRChartInstance = new Chart(ctx1.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Vehicles Without QR', 'Vehicles With QR'],
                    datasets: [{
                        label: 'Total Count',
                        data: [totalVehicles - totalQrGenerated,
                            totalQrGenerated
                        ], // set values dynamically
                        backgroundColor: ['#FF4069', '#36A2EB'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    let totalVehicles = @json($totalVehicles);
    let totalQrGenerated = @json($totalQrGenerated);
    initCharts(totalVehicles, totalQrGenerated);
</script>
