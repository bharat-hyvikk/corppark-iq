<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="deleteModalLabel"></h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Vehicle? </p>
            </div>
            <div class="modal-footer">
                <form action="" id="deleteForm" method="post">
                    @csrf
                    <!-- The buttons should be inside the form -->
                    <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let toastTimeout; // Declare a variable to hold the timeout ID    
        $(document).on('click', '.delete-item', function() {
            deletedealer = $(this).data('id'); // Get the vehicle ID
            let name = $(this).data("name");
            console.log(name);
            $('#deleteModalLabel').text(`Delete Vehicle with Number : ${name}`);
            $('#deleteModal').modal('show'); // Show the modal
        });
        $('#confirmDelete').click(function(e) {
            e.preventDefault();
            var page = $('.pagination .page-item.active .page-link').text();
            let itemsPerPage = $('#itemsPerPage').val(); // Get selected items per page
            let currentPage = $('ul.pagination li.active span.page-link').text();
            let search = $('#search').val();
            let filter = $('input[name="status_rdo"]:checked').val();
            $.ajax({
                type: "post",
                url: "{{ route('vehicles.delete') }}",
                data: {
                    id: deletedealer,
                    itemsPerPage: itemsPerPage,
                    page: page,
                    search: search,
                    status: filter,
                    select_office: selectOffice
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#pageHeaderText").text(response.total);
                    $("#tableContainer").html(response.table);
                    $("#paginationContainer").html(response.pagination);
                    $('#deleteModal').modal('hide'); // Hide the modal
                    $("#successMsgCustom").text(response.message).show();
                    setTimeout(() => {
                        $("#successMsgCustom").text('').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors;

                    $("#errorMsgCustom").text("Failed to delete vehicle");
                    setTimeout(() => {
                        $("#errorMsgCustom").text('').hide();
                    }, 3000);
                }
            });
        });
    });
</script>
