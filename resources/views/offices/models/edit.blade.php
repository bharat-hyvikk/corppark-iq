<div class="modal modal-md" id="editOfficeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Office</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('offices.update') }}" method="post" enctype="multipart/form-data"
                    id="updateForm">
                    @csrf
                    <div class="mb-3">
                        <label for="dealerName" class="form-label">Office Name</label>
                        <input type="text" class="form-control" name='name' aria-describedby="dealerNameHelp"
                            value="{{ old('dealerName') }}" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_name"></label>
                    </div>
                    <div class="mb-3">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" class="form-control" name='owner_name' aria-describedby="dealerNameHelp"
                            class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_owner_name"></label>
                    </div>
                    <div class="mb-3">
                        <label for="office_number" class="form-label">Office Number</label>
                        <input type="text" name="office_number" id="office_number" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_office_number"></label>
                    </div>
                    <div class="mb-3">
                        <label for="dealeremail" class="form-label">Owner Email</label>
                        <input type="email" name="email" id="dealeremail" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_email"></label>
                    </div>
                    <div class="mb-3">
                        <label for="dealer_phone_number" class="form-label">Owner Phone Number</label>
                        <input type="text" name="phone" id="dealer_phone_number" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_phone"></label>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_limit" class="form-label">Vehicle Limit</label>
                        <input type="tel" name="vehicle_limit" id="vehicle_limit" class="form-control">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="edit_vehicle_limit"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateUserBtn">
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
        $(document).on("click", "#editOfficeBtn", function() {
            dealerId = $(this).data('id');
            $.ajax({
                method: "post",
                url: "{{ route('offices.edit') }}",
                data: {
                    id: $(this).data('id')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    $("#updateForm [name='name']").val(response.Office.office_name);
                    $("#updateForm [name='owner_name']").val(response.Office.owner_name);
                    $("#updateForm [name='email']").val(response.Office.owner_email);
                    $("#updateForm [name='phone']").val(response.Office.owner_phone_number);
                    $("#updateForm [name='office_number']").val(response.Office.office_number);
                    $("#updateForm [name='vehicle_limit']").val(response.Office.vehicle_limit);

                    $("#editOfficeModal").modal("show");

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
    $("#updateForm").submit(function(event) {
        event.preventDefault();
        $('#updateUserBtn').find('span').text('Submitting');
        $('#updateUserBtn').find('i').addClass('fa-spin').show();
        $("#updateUserBtn").attr('disabled', true);
        var currentPage = $('ul.pagination li.active span.page-link').text();
        let url = $(this).attr("action");
        let data = $(this).serializeArray();
        let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
        let query = $('#search').val();
        let filter = $('input[name="btnradiotable"]:checked').val();
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

        $.ajax({
            type: "post",
            url: url,
            data: data,
            success: function(response) {
                $("#updateUserBtn").attr('disabled', false);
                $("#pageHeaderText").text(response.total);
                $('#updateUserBtn').find('i').removeClass('fa-spin').hide();
                $('#updateUserBtn').find('span').text('Submit');
                $("#editOfficeModal").modal("hide");
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
                $("#updateUserBtn").attr('disabled', false);
                $('#updateUserBtn').find('i').removeClass('fa-spin').hide();
                $('#updateUserBtn').find('span').text('Submit');
                $.each(errors, function(key, message) {
                    let label = $('#' + "edit_" + key);
                    $(label).html(message).removeClass('d-none');
                    setTimeout(() => {
                        $(label).html(message).addClass('d-none');
                    }, 5000);
                });
                $("#errorMsgCustom").html("Failed to add Office");
                setTimeout(() => {
                    $("#errorMsgCustom").html('').hide();
                }, 3000);
            }
        });
    }); // Closing brace for the submit function
</script>
