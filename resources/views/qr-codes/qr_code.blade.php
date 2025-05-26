<x-app-layout>
    @push('title')
        QR Management
    @endpush
    <main class="main-content d-flex flex-column position-relative border-radius-lg ps min-vh-100 ">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName=" QR Management" />
        </div>
        @include('qr-codes.modal.confirm')
        @include('qr-codes.modal.media')

        <style>
            .search_bar {
                width: 80%;
            }

            .search_bar input {
                border-top-left-radius: 0px !important;
                border-bottom-left-radius: 0px !important;
            }

            .perpage {
                margin-right: 4px;
            }
        </style>
        <div class="container-fluid py-4 px-5 wrapper flex-grow-1">
            @session('noVehicle')
                <div class="alert alert-danger text-center p-1 mb-2 custom-alert">
                    {{ session('noVehicle') }}
                </div>
            @endsession
            @session('Success')
                <div class="alert alert-success text-center p-1 mb-2 custom-alert" id="errorMsgCustom">
                    {{ session('Success') }}
                </div>
            @endsession
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background" style="background: linear-gradient(to right, #735bfc, #965bfc);">
                        </div>
                        <div class="card-body text-start p-4 w-100">
                            <div id="totalContainer">
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Total Vehicles</h3>
                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $vehicleCount ?? 0 }}
                                </p>
                            </div>
                            <h3 class="text-white mb-2" id="search-msg"></h3>

                            <img src="{{ asset('assets/img/3D-object (2).png') }}" alt="3d-cube" {{-- <img src="{{ asset('assets/img/header-title-logo.svg') }}" alt="3d-cube" --}}
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-success w-100 text-center p-1 mb-2" style="display: none" id="addSuccess">
            </div>
            <div class="alert  w-100 text-center p-1 mb-2" style="display: none" id="alert-msg">
            </div>
            <div class="alert alert-danger w-100 text-center p-1 mb-2 search-fail" id="deleteFail"
                style="display: none">
            </div>
            @if (request()->id)
                <div class="row">
                    <div class="col-12">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-header border-bottom pb-0">
                                <div class="row">

                                    <div class="col-6"> <!-- Set the width to 50% using col-6 -->
                                        <h6 class="font-weight-semibold text-lg mb-0">Select Office</h6>
                                        <select id="office-select" class="form-select" style="margin-bottom:2%;">
                                            <option value="">Select office</option>
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id }}" data-slug="{{ $office->slug }}"
                                                    {{ request()->query('id') == $office->id ? 'selected' : '' }}>
                                                    {{ $office->office_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    {{-- <div class="col-5 m-auto" style="margin-left: 5%">
                                        <h6 class="font-weight-semibold text-lg mb-0 mt-4 mx-8">Total  QR:
                                            {{ $totalQrVehiclesCount }}</h6> <!-- Display total count -->
                                    </div> --}}
                                </div>

                                <div class="d-sm-flex align-items-start border-top mt-2">
                                    <!-- Changed align-items-center to align-items-start for vertical alignment -->
                                    <div class="me-auto"> <!-- Added me-auto to push the select office section down -->
                                        <h6 class="font-weight-semibold text-lg mb-0"> QR list</h6>
                                        <p class="text-sm">See information about all QR</p>
                                    </div>
                                    <div class="ms-auto d-flex mt-3">
                                        <a href="{{ route('qrcode.download', ['officeName' => request()->route('officeName'), 'id' => request()->query('id')]) }}"
                                            class="btn btn-sm btn-dark btn-icon me-2">
                                            <span class="btn-inner--icon">
                                                <i class="fa-sharp fa-solid fa-download"
                                                    style="font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            </span>
                                            <span class="btn-inner--text">Download Bulk QR</span>
                                        </a>
                                        <button type="submit"
                                            class="btn btn-sm btn-dark btn-icon me-2 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#generateQRModal">
                                            <span class="btn-inner--icon">
                                                <i class="fa-sharp fa-solid fa-qrcode" id="qrIcon"
                                                    style="font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            </span>
                                            <i class="fa-solid fa-spinner fa-spin" id="qrSpinner"
                                                style="display: none; font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            <span class="btn-inner--text" id="qrBtnText">Generate Bulk QR</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 py-0">
                                <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                    <div class="row align-items-center perpage">
                                        <div class="col-auto">
                                            <label for="items-per-page" class="fw-semibold mb-0">Items per page:</label>
                                        </div>
                                        <div class="col-auto">
                                            <select id="items-per-page" name="items_per_page"
                                                class="form-select form-select-md" style="padding-right:40px;">
                                                <option value="" class="text-left">All</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30" selected>30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center perpage ms-auto">
                                        <div class="col-auto d-flex align-items-center">
                                            <label for="select_all" class="fw-semibold mb-0 me-2">Select all
                                                vehicles</label>
                                            <input type="checkbox" id="select_all">
                                        </div>
                                    </div>

                                    <div class="btn-group ms-auto mx-3" role="group"
                                        aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradiotable" id="reset_btn"
                                            autocomplete="off" data-filter="" value="" checked>
                                        <label class="btn btn-white px-3 mb-0" for="reset_btn">ALL</label>
                                        <input type="radio" class="btn-check" name="btnradiotable"
                                            id="btn_disabled" autocomplete="off" data-filter="SE" value="hasQr">
                                        <label class="btn btn-white px-3 mb-0" for="btn_disabled">Generated</label>
                                        <input type="radio" class="btn-check" name="btnradiotable" id="btn_aso"
                                            autocomplete="off" data-filter="ASO" value="noQr">
                                        <label class="btn btn-white px-3 mb-0" for="btn_aso">Not Generated</label>
                                    </div>
                                    <div class="input-group w-sm-25  grid grid-cols-1">
                                        <span class="input-group-text text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search"
                                            id="qrsearch" name="search">
                                    </div>
                                </div>

                                <div class="table-responsive p-0" id="Table">
                                    @include('qr-codes.partials.qr_table')
                                </div>
                                {{-- <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    {{-- <button class="btn btn-sm btn-white mb-0">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0">Next</button> --}}{{--
                                    {{ $qrCodes->links() }}

                                </div>
                            </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-header border-bottom pb-0">
                                <div class="col-6"> <!-- Set the width to 50% using col-6 -->
                                    <h6 class="font-weight-semibold text-lg mb-0">Select Office</h6>
                                    <select id="office-select" class="form-select" style="margin-bottom:2%;">
                                        <option value="">Select office</option>
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}" data-id="{{ $office->id }}"
                                                data-slug="{{ $office->office_name }}"
                                                {{ request()->query('id') == $office->id ? 'selected' : '' }}>
                                                {{ $office->office_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-sm-flex align-items-start border-top">
                                    <!-- Changed align-items-center to align-items-start for vertical alignment -->
                                    <div class="me-auto"> <!-- Added me-auto to push the select office section down -->
                                        <h6 class="font-weight-semibold text-lg mb-0"> QR list</h6>
                                        <p class="text-sm">See information about all QR</p>
                                    </div>
                                    <div class="ms-auto d-flex mt-3">
                                        <a href="{{ route('qrcode.download', ['officeName' => request()->route('officeName'), 'id' => request()->query('id')]) }}"
                                            class="btn btn-sm btn-dark btn-icon me-2">
                                            <span class="btn-inner--icon">
                                                <i class="fa-sharp fa-solid fa-download"
                                                    style="font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            </span>
                                            <span class="btn-inner--text">Download Bulk QR</span>
                                        </a>
                                        <button type="submit"
                                            class="btn btn-sm btn-dark btn-icon me-2 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#generateQRModal">
                                            <span class="btn-inner--icon">
                                                <i class="fa-sharp fa-solid fa-qrcode" id="qrIcon"
                                                    style="font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            </span>
                                            <i class="fa-solid fa-spinner fa-spin" id="qrSpinner"
                                                style="display: none; font-size: 0.75rem; margin-right: 0.2rem;"></i>
                                            <span class="btn-inner--text" id="qrBtnText">Generate Bulk Branded
                                                QR</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
<script>
    $(document).ready(function() {
        let selectedVehicles = [];
        $('#office-select').on('change', function() {
            var officeId = $(this).find(':selected').val(); //
            if (officeId) {
                // Redirect to the route with the selected officeName (slug)
                window.location.href = '{{ route('qrcode.index') }}'  + '?id=' +
                    officeId;
            }
        });
        $(document).on('change', 'input[name="select_vehicle"]', function() {
            const vehicleId = $(this).val();
            if ($(this).is(':checked')) {
                // If checked, add the value to the array
                if (!selectedVehicles.includes(vehicleId)) {
                    selectedVehicles.push(vehicleId);
                }
            } else {
                // If unchecked, remove the value from the array
                selectedVehicles = selectedVehicles.filter(id => id !== vehicleId);
            }
        });
        $('#select_all').change(function() {
            // Check if 'select all' is checked
            const isChecked = $(this).is(':checked');
            if (!isChecked) {
                selectedVehicles = []; // Reset selectedVehicles array if 'select all' is unchecked
                console.log("inside if");
                $('#qr_table_body input[name="select_vehicle"]').each(function() {
                    // Only check if checkbox is not disabled
                    if (!$(this).is(':disabled')) {
                        $(this).prop('checked', isChecked);
                    }
                });
            } else {
                // Toggle all checkboxes with name 'select_vehicle' in #qr_table_body based on 'select all' checkbox
                $('#qr_table_body input[name="select_vehicle"]').each(function() {
                    // Only check if checkbox is not disabled
                    const vehicleId = $(this).val();
                    if (!$(this).is(':disabled')) {
                        $(this).prop('checked', isChecked);
                        if (!selectedVehicles.includes(vehicleId)) {
                            selectedVehicles.push(vehicleId);
                        }
                    }
                });
            }
        });
        $('#generate-qr-btn-modal').click(function(event) {
            event.preventDefault();
            $("#generateQRModal").modal("hide");
            $('#qrSpinner').show(); // Show spinner
            $('#qrIcon').hide(); // Hide QR icon
            $('#qrBtnText').text('Generating'); // Change button text to 'Generating...'
            customUrl = $('#qrForm').attr("action");
            let generateQrUrl =
                "{{ route('qrcode.generate', ['id' => request()->query('id')]) }}";
            $('#qrForm').attr('action', generateQrUrl);
            let ele = $('#qrForm')[0];
            console.log(ele);
            let deSelectedVehicles = $('input[name="select_vehicle"]:not(:checked)').map(function() {
                // Exclude disabled checkboxes
                if (!$(this).is(':disabled')) {
                    return $(this).val(); // Return value of unchecked and enabled checkboxes
                }
            }).get();
            let selectedVehicles = $('input[name="select_vehicle"]:checked').map(function() {
                return $(this).val();
            }).get();
            // Clear any previous dynamically added hidden input
            $('#qrForm').find('input[name="selected_vehicles"]').remove();
            const isChecked = $("#select_all").is(':checked');
            // Append selectedVehicles array as a single hidden input
            $('<input>').attr({
                type: 'hidden',
                name: 'de_selected_vehicles',
                value: JSON.stringify(deSelectedVehicles) // Store as JSON string
            }).appendTo('#qrForm');
            $('<input>').attr({
                type: 'hidden',
                name: 'selected_vehicles',
                value: JSON.stringify(selectedVehicles) // Store as JSON string
            }).appendTo('#qrForm');
            $('<input>').attr({
                type: 'hidden',
                name: 'selected_all',
                value: isChecked
            }).appendTo('#qrForm');
            $('#qrBtnText').text('Generating'); // Change button text to 'Generating...'
             $('#qrForm').submit();
        });
        $(document).on('click', '.btn-check', function(e) {
            let filter = $('input[name="btnradiotable"]:checked').val();
            let query = $('#qrsearch').val();
            let itemsPerPage = $('#items-per-page').val(); // Get selected items per page
            performSearch(itemsPerPage, query, filter);
        });
        $('#qrsearch').on('keyup', function(e) {
            typingTimer = setTimeout(function() {
                let query = $('#qrsearch').val();
                let filter = $('input[name="btnradiotable"]:checked').val();
                let itemsPerPage = $('#items-per-page').val(); // Get selected items per page
                performSearch(itemsPerPage, query, filter);
            }, 1000);
        });
        $(document).on('click', '.pagination a', function(event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            $('html, body').scrollTop(250); // Instant scroll
            //  $('html, body').scrollTop(50); // Instant scroll
            let query = $('#qrsearch').val();
            var page = $(this).attr('href').split('page=')[1];
            let filter = $('input[name="btnradiotable"]:checked').val();
            let itemsPerPage = $('#items-per-page').val(); // Get selected items per page
            performSearch(itemsPerPage, query, filter, page);
        });
        $('#items-per-page').on('change', function() {
            var itemsPerPage = $(this).val();
            let query = $('#qrsearch').val();
            let filter = $('input[name="btnradiotable"]:checked').val();
            performSearch(itemsPerPage, query, filter);
        });

        // $('#generate-qr-btn').click(function() {
        //     $.ajax({
        //         url: "{{ route('qrcode.generate') }}",
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             if (response.success) {
        //                 // Show success message
        //                 $("#successMsgCustom").text(response.message).removeClass('d-none')
        //                     .show();
        //                 setTimeout(() => {
        //                     $("#successMsgCustom").text('').addClass('d-none')
        //                         .hide();
        //                 }, 3000);
        //             }
        //         },
        //         error: function(response) {
        //             // Show error message
        //             let message = response.responseJSON.message || 'An error occurred.';
        //             $("#errorMsgCustom").text(message).removeClass('d-none').show();
        //             setTimeout(() => {
        //                 $("#errorMsgCustom").text('').addClass('d-none').hide();
        //             }, 5000);
        //         }
        //     });
        // });

        function performSearch(itemsPerPage, query, filter, page = 1) { // Added function keyword here
            console.log(selectedVehicles);
            let officeName = $("#office-select").val();
            let id = "{{ request()->query('id') }}";
            $.ajax({
                url: "{{ route('qrcode.index', ['officeName' => request()->route('officeName')]) }}",
                type: 'GET',
                data: {
                    itemsPerPage: itemsPerPage,
                    search: query,
                    filter: filter,
                    page: page,
                    id: id,
                }, // Added comma here
                success: function(response) {
                    $('#Table').html(response.html);
                    const isChecked = $("#select_all").is(':checked');
                    $('#qr_table_body input[name="select_vehicle"]').each(function() {
                        // Only check if checkbox is not disabled
                        const vehicleId = $(this).val();
                        if (!$(this).is(':disabled')) {
                            $(this).prop('checked', isChecked);
                            if (isChecked) {
                                if (!selectedVehicles.includes(vehicleId)) {
                                    selectedVehicles.push(vehicleId);
                                }
                            }
                        }
                    });
                    selectedVehicles.forEach(function(vehicleId) {
                        $(`#selected_vehicle_${vehicleId}`).prop('checked',
                            isChecked); // Use the checkbox ID to set it as checked
                    });
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $("#pageHeaderText").text(response.count);
                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON;
                    console.log(errors);
                }
            });
        }
    });
</script>
