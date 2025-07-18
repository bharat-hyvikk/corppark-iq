<div class="modal modal-md" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Building</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buildings.update') }}" method="post" enctype="multipart/form-data"
                    id="updateForm">
                    @csrf
                   <div class="mb-3">
                        <label class="form-label">Building Name</label>
                        <input type="text" class="form-control" name='building_name'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_building_name"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building Address</label>
                        <textarea class="form-control" name='building_address' aria-describedby="dealerNameHelp" class="form-control"
                            autocomplete="off"></textarea>
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_building_address"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building Image</label>
                        <input type="file" class="form-control" name='building_image' aria-describedby="dealerNameHelp"
                            class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_building_image"></label>
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
        $(document).on("click", "#editBuildingBtn", function() {

            dealerId = $(this).data('id');
            $.ajax({
                method: "post",
                url: "{{ route('buildings.edit') }}",
                data: {
                    id: $(this).data('id')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("[name='building_name']").val(response.building.building_name);
                    $("[name='building_address']").val(response.building.building_address);
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
        // let filter = $('input[name="status_rdo"]:checked').val();
        console.log(dealerId);
        data.push({
            name: "id",
            value: dealerId
        })
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
