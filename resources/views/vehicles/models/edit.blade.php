<div class="modal modal-md" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Vehicle</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicles.update') }}" method="post" enctype="multipart/form-data"
                    id="updateForm">
                    @csrf
                   <div class="mb-3">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" class="form-control" name='vehicle_number'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_vehicle_number"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Owner Number</label>
                        <input type="tel" class="form-control" name='phone' aria-describedby="dealerNameHelp"
                            class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_phone"></label>
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
                            id="edit_office_id"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateVehicleBtn">
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
    let dealerId;
    $(document).ready(function() {
       

        $(document).on("click", "#editVehicleBtn", function() {
            
            dealerId = $(this).data('id');
            $.ajax({
                method: "post",
                url: "{{ route('vehicles.edit') }}",
                data: {
                    id: $(this).data('id')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("[name='vehicle_number']").val(response.vehicle.vehicle_number);
                    $("[name='office_id']").val(response.vehicle.office_id)
                    $("[name='email']").val(response.vehicle.email);
                    $("[name='phone']").val(response.vehicle.owner_phone);
                    $("#editModal").modal("show");

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });


    });
    $("#updateForm").submit(function(event) {
        event.preventDefault();
        $('#updateVehicleBtn').find('span').text('Submitting');
        $('#updateVehicleBtn').find('i').addClass('fa-spin').show();
        $("#updateVehicleBtn").attr('disabled', true);
        var currentPage = $('ul.pagination li.active span.page-link').text();
        let url = $(this).attr("action");
        let data = $(this).serializeArray();
        let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
        let query = $('#search').val();
        let filter = $('input[name="status_rdo"]:checked').val();
        console.log(dealerId);
        data.push({
            name: 'itemsPerPage',
            value: itemsPerPage
        });
        data.push({
            name: "id",
            value: dealerId
        })
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
         data.push({
                name:"select_office",
                value: selectOffice
            });

        $.ajax({
            type: "post",
            url: url,
            data: data,
            success: function(response) {
                $("#updateVehicleBtn").attr('disabled', false);
                $("#pageHeaderText").text(response.total);
                $('#updateVehicleBtn').find('i').removeClass('fa-spin').hide();
                $('#updateVehicleBtn').find('span').text('Submit');
                $("#editModal").modal("hide");
                $("#updateForm")[0].reset();
                $("#tableContainer").html(response.table);
                $("#paginationContainer").html(response.pagination);
                $("#successMsgCustom").text(response.message).show();
                setTimeout(() => {
                    $("#successMsgCustom").text('').hide();
                }, 3000);

            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors; // Renamed to avoid conflict
                $("#updateVehicleBtn").attr('disabled', false);
                $('#updateVehicleBtn').find('i').removeClass('fa-spin').hide();
                $('#updateVehicleBtn').find('span').text('Submit');
                $.each(errors, function(key, message) {
                    let label = $('#' + "edit_" + key);
                    $(label).html(message).removeClass('d-none');
                    setTimeout(() => {
                        $(label).html(message).addClass('d-none');
                    }, 5000);
                });
                $("#errorMsgCustom").html("Failed to add vehicle");
                setTimeout(() => {
                    $("#errorMsgCustom").html('').hide();
                }, 3000);
            }
        });
    }); // Closing brace for the submit function
</script>
