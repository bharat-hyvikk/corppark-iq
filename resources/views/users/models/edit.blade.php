<div class="modal modal-md" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    <div class="mb-3">
                        <label for="dealerName" class="form-label">User Name</label>
                        <input type="text" class="form-control" name='name' aria-describedby="dealerNameHelp"
                            value="{{ old('dealerName') }}" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_name"></label>
                    </div>
                    <div class="mb-3">
                        <label for="edit_user_type_label" class="form-label">User Type</label>
                        <select class="form-select" id="edit_user_type_label" name="user_type">
                            <option value="" selected disabled>Select User Type</option>
                            <option value="0">Guard</option>
                            @if (auth()->user()->user_type == '1')
                                <option value="2">Manager</option>
                            @endauth
                            <option value="3">Submanager</option>
                    </select>
                    <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                        id="edit_user_type"></label>
                </div>
                @if (auth()->user()->user_type == '1')

                    <div class="mb-3">
                        <label for="edit_bulding_label" class="form-label">Building Name</label>
                        <select class="form-select" id="edit_bulding_label" name="building">
                            <option value="" selected disabled>Select Building Name</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                            @endforeach
                        </select>
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building"></label>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="dealeremail" class="form-label">Email</label>
                    <input type="email" name="email" id="dealeremail" class="form-control">
                    <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_email"></label>
                </div>
                <div class="mb-3">
                    <label for="dealer_phone_number" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" id="dealer_phone_number" class="form-control">
                    <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none" id="edit_phone"></label>
                </div>
                <div class="mb-3">
                    <label for="dealer_password" class="form-label">New Password</label>
                    <div class="input-group w-full">
                        <input type="password" name="password" id="edit_dealer_password" class="form-control">
                        <span class="input-group-text bg-white" id="edittogglePassword" style="cursor: pointer;">
                            <i class="fas fa-eye" id="edit_password_icon"></i>
                        </span>
                    </div>
                    <label class="bg-danger text-white form-label w-100 mt-2 p-2 d-none" id="edit_password"></label>
                </div>
                <div class="mb-3  editpermissions">
                    <label class="form-label">Offices Permissions</label>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="office.add" id="add"
                                name="permissions[]">
                            <label class="form-check-label" for="add">
                                Add
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="office.update" id="update"
                                name="permissions[]">
                            <label class="form-check-label" for="create">
                                Update
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="office.delete" id="delete"
                                name="permissions[]">
                            <label class="form-check-label" for="delete">
                                Delete
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3  editpermissions">
                    <label class="form-label">Vehicles Permissions</label>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="vehicle.add" id="add"
                                name="permissions[]">
                            <label class="form-check-label" for="add">
                                Add
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="vehicle.update"
                                id="update" name="permissions[]">
                            <label class="form-check-label" for="create">
                                Update
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="vehicle.delete"
                                id="delete" name="permissions[]">
                            <label class="form-check-label" for="delete">
                                Delete
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3  editpermissions">
                    <label class="form-label">QR Permissions</label>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="qr.generate" id="generate"
                                name="permissions[]">
                            <label class="form-check-label" for="generate">
                                Generate
                            </label>
                        </div>
                    </div>
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
        document.querySelector("#edittogglePassword").addEventListener("click", function() {
            const passwordField = document.querySelector("#edit_dealer_password");
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            $("#edit_password_icon").toggleClass("fa-eye-slash");
            $("#edit_password_icon").toggleClass("fa-eye");
        });

        $("#edit_user_type_label").change(function(e) {
            let type = $(this).val();
            console.log(type);
            if (type == "3") {
                $(".editpermissions").removeClass("d-none");
            } else {
                $(".editpermissions").addClass("d-none");
            }
        });
        $('#editModal').on('hidden.bs.modal', function() {
            $("#updateForm")[0].reset();
            $(".editpermissions").addClass("d-none");

        });

        $(document).on("click", "#editUserBtn", function() {
            dealerId = $(this).data('id');
            $.ajax({
                method: "post",
                url: "{{ route('users.edit') }}",
                data: {
                    id: $(this).data('id')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let user = response.user;
                    let userPermissions = response.permissions;
                    console.log(userPermissions);
                    $("[name='name']").val(response.user.name);
                    $("[name='email']").val(response.user.email);
                    $("[name='phone']").val(response.user.phone);
                    // reset password field 
                    $("[name='password']").val("");
                    // set building 
                    $("[name='building']").val(response.user.building_id);
                    $("#edit_user_type_label").val(response.user.user_type)
                    if (user.user_type == "3") {
                        $(".editpermissions").removeClass("d-none");
                    } else {
                        $(".editpermissions").addClass("d-none");
                    }
                    let allPermissions = $("[name='permissions[]']");
                    allPermissions.each(function() {
                        let permissionValue = $(this).val();
                        if (userPermissions.includes(permissionValue)) {
                            $(this).prop('checked', true);
                        }
                    });




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
                $("#errorMsgCustom").html("Failed to add user");
                setTimeout(() => {
                    $("#errorMsgCustom").html('').hide();
                }, 3000);
            }
        });
    }); // Closing brace for the submit function
</script>
