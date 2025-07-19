<div class="modal modal-md" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Office</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('offices.save') }}" method="post" enctype="multipart/form-data"
                    id="addUserForm" class="row">
                    @csrf
                    <div class="mb-3 col-6">
                        <label for="dealerName" class="form-label">Office Name</label>
                        <input type="text" class="form-control" name='name' aria-describedby="dealerNameHelp"
                            value="{{ old('dealerName') }}" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="add_name"></label>
                    </div>
                    @if (auth()->user()->user_type == '1')
                        <div class="mb-3 col-6">
                            <label for="add_bulding_label" class="form-label">Building Name</label>
                            <select class="form-select" id="add_bulding_label" name="building">
                                <option value="" selected disabled>Select Building Name</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                                @endforeach
                            </select>
                            <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                                id="add_building"></label>
                        </div>
                    @endif
                    <div class="mb-3 col-6">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" class="form-control" name='owner_name' aria-describedby="dealerNameHelp"
                            class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_owner_name"></label>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="office_number" class="form-label">Office Number</label>
                        <input type="text" name="office_number" id="office_number" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_office_number"></label>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="dealeremail" class="form-label">Owner Email</label>
                        <input type="email" name="email" id="dealeremail" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="add_email"></label>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="dealer_phone_number" class="form-label">Owner Phone Number</label>
                        <input type="text" name="phone" id="dealer_phone_number" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="add_phone"></label>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="vehicle_limit" class="form-label">Vehicle Limit</label>
                        <input type="tel" name="vehicle_limit" id="vehicle_limit" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_vehicle_limit"></label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addUserBtn">
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

        $("#addUserForm").submit(function(event) {
            event.preventDefault();
            $('#addUserBtn').find('span').text('Submitting');
            $('#addUserBtn').find('i').addClass('fa-spin').show();
            $("#addUserBtn").attr('disabled', true);
            var currentPage = $('ul.pagination li.active span.page-link').text();
            let url = $(this).attr("action");
            let data = $(this).serializeArray();
            let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
            let query = $('#officesSearch').val();
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

            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    $("#addUserBtn").attr('disabled', false);
                    $("#pageHeaderText").text(response.total);
                    $('#addUserBtn').find('i').removeClass('fa-spin').hide();
                    $('#addUserBtn').find('span').text('Submit');
                    $("#addModal").modal("hide");
                    $("#addUserForm")[0].reset();
                    $("#tableContainer").html(response.table);
                    $("#paginationContainer").html(response.pagination);
                    $("#successMsgCustom").text(response.message).show();
                    setTimeout(() => {
                        $("#successMsgCustom").text('').hide();
                    }, 3000);

                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors; // Renamed to avoid conflict
                    let PermissionMessage = xhr.responseJSON.permissionMessage;
                    $("#addUserBtn").attr('disabled', false);
                    $('#addUserBtn').find('i').removeClass('fa-spin').hide();
                    $('#addUserBtn').find('span').text('Submit');
                    $.each(errors, function(key, message) {
                        let label = $('#' + "add_" + key);
                        $(label).html(message).removeClass('d-none');
                        setTimeout(() => {
                            $(label).html(message).addClass('d-none');
                        }, 5000);
                    });
                    if (PermissionMessage) {
                        $("#errorMsgCustom").text(PermissionMessage).show();
                        $("#addModal").modal("hide");
                    }
                    setTimeout(() => {
                        $("#errorMsgCustom").html('').hide();
                    }, 3000);
                }
            });
        }); // Closing brace for the submit function
    }); // Closing brace for $(document).ready
</script>
