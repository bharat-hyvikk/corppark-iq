<div class="modal modal-md" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Building</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buildings.save') }}" method="post" enctype="multipart/form-data"
                    id="addBuildingForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Building Name</label>
                        <input type="text" class="form-control" name='building_name'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building_name"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building Address</label>
                        <textarea class="form-control" name='building_address' aria-describedby="dealerNameHelp" class="form-control"
                            autocomplete=""></textarea>
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building_address"></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building Images</label>
                        <input type="file" class="form-control" name='building_images'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building_images"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addBuildingBtn">
                            <i class="fa-solid fa-spinner" style="display: none;"></i> <span
                                id="btn-text">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $("#addBuildingForm").submit(function (event) {
        event.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);

        // UI: Disable button and show spinner
        $('#addBuildingBtn').attr('disabled', true);
        $('#addBuildingBtn').find('span').text('Submitting');
        $('#addBuildingBtn').find('i').addClass('fa-spin').show();

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#addBuildingBtn').attr('disabled', false);
                $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                $('#addBuildingBtn').find('span').text('Submit');

                $('#addModal').modal('hide');
                $('#addBuildingForm')[0].reset();
                $("#tableContainer").html(response.table);

                $("#successMsgCustom").text(response.message).show();
                setTimeout(() => {
                    $("#successMsgCustom").text('').hide();
                }, 3000);
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};

                $('#addBuildingBtn').attr('disabled', false);
                $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                $('#addBuildingBtn').find('span').text('Submit');

                $.each(errors, function (key, message) {
                    const label = $('#add_' + key);
                    label.html(message).removeClass('d-none');
                    setTimeout(() => {
                        label.html('').addClass('d-none');
                    }, 5000);
                });

                $("#errorMsgCustom").html("Failed to add building").show();
                setTimeout(() => {
                    $("#errorMsgCustom").html('').hide();
                }, 3000);
            }
        });
    });
});
</script>

{{-- <script>
    $(document).ready(function() {

        $("#addBuildingForm").submit(function(event) {
            event.preventDefault();
            $('#addBuildingBtn').find('span').text('Submitting');
            $('#addBuildingBtn').find('i').addClass('fa-spin').show();
            $("#addBuildingBtn").attr('disabled', true);
            // var currentPage = $('ul.pagination li.active span.page-link').text();
            let url = $(this).attr("action");
            let data = $(this).serializeArray();

            // let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
            // let query = $('#vehiclesSearch').val();
        // let filter = $('input[name="status_rdo"]:checked').val();
            // data.push({
            //     name: 'itemsPerPage',
            //     value: itemsPerPage
            // });
            // data.push({
            //     name: 'search',
            //     value: query
            // });
            // data.push({
            //     name: 'currentPage',
            //     value: currentPage
            // });
            // data.push({
            //     name: 'status',
            //     value: filter
            // });
            // // Add the selected page number to the data
            // data.push({
                name:"select_office",
                value: selectOffice
            });

            $.ajax({
                type: "post",
                url: url,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#addBuildingBtn").attr('disabled', false);
                    // $("#pageHeaderText").text(response.total);
                    $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                    $('#addBuildingBtn').find('span').text('Submit');
                    $("#addModal").modal("hide");
                    $("#addVehicleForm")[0].reset();
                    $("#tableContainer").html(response.table);
                    // $("#paginationContainer").html(response.pagination);
                    $("#successMsgCustom").text(response.message).show();
                    setTimeout(() => {
                        $("#successMsgCustom").text('').hide();
                    }, 3000);

                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors; // Renamed to avoid conflict
                    $("#addBuildingBtn").attr('disabled', false);
                    $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                    $('#addBuildingBtn').find('span').text('Submit');
                    $.each(errors, function(key, message) {
                        let label = $('#' + "add_" + key);
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
    // }); // Closing brace for $(document).ready
</script> --}}
