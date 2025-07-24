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
                    id="addBuildingForm" class="row">
                    @csrf
                    <div class="mb-3 col-6">
                        <label class="form-label">Building Name</label>
                        <input type="text" class="form-control" name='building_name'
                            aria-describedby="dealerNameHelp" class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building_name"></label>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="owner_name" class="form-label">Owner Name</label>
                        <input type="text" class="form-control" name='owner_name' aria-describedby="dealerNameHelp"
                            class="form-control" autocomplete="">
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_owner_name"></label>
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
                        <label class="form-label">Building Address</label>
                        <textarea class="form-control" name='building_address' aria-describedby="dealerNameHelp" class="form-control"
                            autocomplete=""></textarea>
                        <label class="bg-danger text-white  form-label w-100 mt-2 p-2 d-none"
                            id="add_building_address"></label>
                    </div>
                    <div class="mb-3 col-6">
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
    $(document).ready(function() {
        $("#addBuildingForm").submit(function(event) {
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
                success: function(response) {
                    $('#addBuildingBtn').attr('disabled', false);
                    $("#pageHeaderText").text(response.total);
                    $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                    $('#addBuildingBtn').find('span').text('Submit');

                    $('#addModal').modal('hide');
                    $('#addBuildingForm')[0].reset();
                    $("#tableContainer").html(response.table);
                    // console.log(response);

                    $("#successMsgCustom").text(response.message).show();
                    setTimeout(() => {
                        $("#successMsgCustom").text('').hide();
                    }, 3000);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors || {};

                    $('#addBuildingBtn').attr('disabled', false);
                    $('#addBuildingBtn').find('i').removeClass('fa-spin').hide();
                    $('#addBuildingBtn').find('span').text('Submit');

                    $.each(errors, function(key, message) {
                        const label = $('#add_' + key);
                        label.html(message).removeClass('d-none');
                        setTimeout(() => {
                            label.html('').addClass('d-none');
                        }, 5000);
                    });

                    // $("#errorMsgCustom").html("Failed to add building").show();
                    // setTimeout(() => {
                    //     $("#errorMsgCustom").html('').hide();
                    // }, 3000);
                }
            });
        });
    });
</script>
