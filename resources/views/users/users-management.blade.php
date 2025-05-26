<x-app-layout>

    <main class="main-content d-flex flex-column position-relative border-radius-lg ps min-vh-100 ">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName="User Management" />
        </div>
        {{-- @include('UserManage.model.view-dairy')
        @include('UserManage.model.edit')
        @include('UserManage.model.confirm') --}}
        @include('users.models.add')
        @include('users.models.edit')
        @include('users.models.confirm')
        <div class="container-fluid py-4 px-5 flex-grow-1 wrapper">
            <div class="alert alert-success text-center p-1 mb-2 custom-alert" id="successMsgCustom"
                style="display: none;">
            </div>
            <div class="alert alert-danger text-center p-1 mb-2 custom-alert" id="errorMsgCustom" style="display: none">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background" style="background: linear-gradient(to right, #735bfc, #965bfc);">
                        </div>
                        <div class="card-body text-start p-4 w-100">
                            <div id="totalContainer">
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Total User</h3>
                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $users->total() }}
                                </p>
                            </div>
                            <h3 class="text-white mb-2" id="search-msg"></h3>

                            <img src="{{ asset('assets/img/3D-object (2).png') }}" alt="3d-cube" {{-- <img src="{{ asset('assets/img/header-title-logo.svg') }}" alt="3d-cube" --}}
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">User list</h6>
                                    <p class="text-sm">See information about all user</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    {{-- <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button> --}}
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                        class="btn btn-sm btn-icon d-flex align-items-center me-2" id="addModalBtn"
                                        style="background-color:#735bfc">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2"
                                                style="color:#FFF">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text" style="color:#fff">Add User</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="row align-items-center perpage">
                                    <div class="col-auto">
                                        <label for="itemsPerPage" class="fw-semibold mb-0">Items per page:</label>
                                    </div>
                                    <div class="col-auto">
                                        <select id="itemsPerPage" name="items_per_page" onchange="filterTable()"
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
                                <div class="btn-group ms-auto mx-3 ms-auto" role="group"
                                    aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="status_rdo" id="reset_btn"
                                        autocomplete="off" value="" checked />
                                    <label class="btn btn-white px-3 mb-0" for="reset_btn">ALL</label>

                                    <input type="radio" class="btn-check" name="status_rdo" id="btn_disabled"
                                        autocomplete="off" value="Active" />
                                    <label class="btn btn-white px-3 mb-0" for="btn_disabled">Active</label>

                                    <input type="radio" class="btn-check" name="status_rdo" id="btn_aso"
                                        autocomplete="off" value="Inactive" />
                                    <label class="btn btn-white px-3 mb-0" for="btn_aso">Inactive</label>
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
                                    <input type="text" class="form-control" placeholder="Search" id="search"
                                        name="search">
                                </div>
                            </div>
                            <div class="table-responsive p-0" id="tableContainer">
                                @include('users.partials.users_table', [
                                    'users' => $users,
                                ])
                            </div>
                            {{-- <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    {{-- <button class="btn btn-sm btn-white mb-0">Previous</button>
                                     <button class="btn btn-sm btn-white mb-0">Next</button> --}}{{--
                                    {{$books->links() }}

                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#multiSectionModal').on('shown.bs.modal', function() {
        $('#personal-tab').trigger('click');
    });
    $("#addModalBtn").click(function() {
        // reset form  addUserForm
        $("#addUserForm")[0].reset();
    })
     $(document).on("click", ".toggle-status", function(e) {
            let toastTimeout; // Declare a variable to hold the timeout ID    
            $(this).toggleClass("fa-toggle-on");
            $(this).toggleClass("fa-toggle-off");
            let element = $(this);
            let id = $(this).data("id");

            let data = {
                id: id
            }
            $.ajax({
                type: "post",
                url: "{{ route('users.toggleStatus') }}",
                data: data,
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // $("#successMsgCustom").addClass('animate');
                    $("#successMsgCustom").text(response.message).show();
                    // if ($("#successMsgCustom").is(':visible')) {
                    //     $("#successMsgCustom").text(response.message);
                    // } else {
                    //     $("#successMsgCustom").text(response.message).show();
                    // }
                    let userStatus = response.userStatus;
                    clearTimeout(toastTimeout); // Clear any existing timeout
                    if (userStatus=="Active") {
                        element.attr("data-bs-title", "Deactivate User");

                    } else {
                        element.attr("data-bs-title", "Activate User");

                    }
                    element.tooltip("dispose");
                    element.tooltip();
                    setTimeout(() => {

                        // $("#successMsgCustom").removeClass('animate');

                        $("#successMsgCustom").text('').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    $("#errorMsgCustom").text("Failed to update status");
                    setTimeout(() => {
                        $("#errorMsgCustom").text('').hide();
                    }, 3000);
                }
            });

        });
    $(document).on("click", 'input[name="status_rdo"]', function() {
        filterTable();
    });
    var timeout;
    $("#search").on("keyup", function() {
        console.log("search");
        clearTimeout(timeout);
        timeout = setTimeout(filterTable, 1000);
    });
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        $('html, body').scrollTop(250); // Instant scrol
        var page = $(this).attr('href').split('page=')[1];
        filterTable(page);
    });


    function filterTable($page = 1) {
        let searchInput = $('#search').val().toLowerCase();
        let itemsPerPage = $('#itemsPerPage').val();
        //get ship name selectship
        let shipName = $('#selectship').val();
        //get the btnradiotable value
        let status = $("[name='status_rdo']:checked").val();
        console.log(status);
        $.ajax({
            type: "GET",
            url: "users/manage",
            data: {
                search: searchInput,
                itemsPerPage: itemsPerPage,
                page: $page,
                status: status,
            },
            success: function(response) {
                $('#tableContainer').html(response.table);
                // set count using total
                console.log(response)
                $('#pageHeaderText').text(response.total);
                $('#paginationContainer').html(response.pagination);
                document.querySelector("main").scroll({
                    top: 0,
                    left: 0,
                });

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    }
</script>
