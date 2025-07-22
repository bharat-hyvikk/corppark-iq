<div class="modal modal-md" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Vehicle</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicles.save') }}" method="post" enctype="multipart/form-data"
                    id="addVehicleForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" class="form-control" name='vehicle_number'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_vehicle_number"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Owner Number</label>
                        <input type="tel" class="form-control" name='phone' aria-describedby="dealerNameHelp"
                            class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="add_phone"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Office</label>
                        <select name="office_id" id="office_id" class="form-control">
                            <option value="">Select Office</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                            @endforeach
                        </select>
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_office_id"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addVehicleBtn">
                            <i class="fa-solid fa-spinner" style="display: none;"></i> <span
                                id="btn-text">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $("#addVehicleForm").submit(function(event) {
            event.preventDefault();
            $('#addVehicleBtn').find('span').text('Submitting');
            $('#addVehicleBtn').find('i').addClass('fa-spin').show();
            $("#addVehicleBtn").attr('disabled', true);
            var currentPage = $('ul.pagination li.active span.page-link').text();
            let url = $(this).attr("action");
            let data = $(this).serializeArray();
            let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
            let query = $('#vehiclesSearch').val();
            let filter = $('input[name="status_rdo"]:checked').val();
            data.push({
                name: 'itemsPerPage',
                value: itemsPerPage
            });
            data.push({
                name: 'search',
                value: query
            });
            data.push({
                name: 'currentPage',
                value: currentPage
            });
            data.push({
                name: 'status',
                value: filter
            });
            // Add the selected page number to the data
            data.push({
                name: "select_office",
                value: selectOffice
            });

            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    $("#addVehicleBtn").attr('disabled', false);
                    $("#pageHeaderText").text(response.total);
                    $('#addVehicleBtn').find('i').removeClass('fa-spin').hide();
                    $('#addVehicleBtn').find('span').text('Submit');
                    $("#addModal").modal("hide");
                    $("#addVehicleForm")[0].reset();
                    $("#tableContainer").html(response.table);
                    $("#paginationContainer").html(response.pagination);
                    $("#successMsgCustom").text(response.message).show();
                    setTimeout(() => {
                        $("#successMsgCustom").text('').hide();
                    }, 3000);

                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors; // Renamed to avoid conflict
                    let PermissionMessage = xhr.responseJSON.message;

                    $("#addVehicleBtn").attr('disabled', false);
                    $('#addVehicleBtn').find('i').removeClass('fa-spin').hide();
                    $('#addVehicleBtn').find('span').text('Submit');
                    $.each(errors, function(key, message) {
                        let label = $('#' + "add_" + key);
                        $(label).html(message).removeClass('d-none');
                        setTimeout(() => {
                            $(label).html(message).addClass('d-none');
                        }, 5000);
                    });
                    if (PermissionMessage && xhr.status == 403) {
                        $("#errorMsgCustom").text(PermissionMessage).show();
                        $("#addModal").modal("hide");
                        setTimeout(() => {
                            $("#errorMsgCustom").html('').hide();
                        }, 3000);
                    }
                }
            });
        }); // Closing brace for the submit function
    }); // Closing brace for $(document).ready
</script>
