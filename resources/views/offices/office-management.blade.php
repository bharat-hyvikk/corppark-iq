<x-app-layout>

    <main class="main-content d-flex flex-column position-relative border-radius-lg ps min-vh-100 ">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName="Office Management" />
        </div>
        {{-- @include('UserManage.model.view-dairy')
        @include('UserManage.model.edit')
        @include('UserManage.model.confirm') --}}
        @include('offices.models.add')
        @include('offices.models.edit')
        @include('offices.models.confirm')
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
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Total Office</h3>
                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $offices->total() }}
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
                                    <h6 class="font-weight-semibold text-lg mb-0">Office list</h6>
                                    <p class="text-sm">See information about all Office</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                            style="background-color:#735bfc"
                                            class="btn btn-sm  btn-icon d-flex align-items-center me-2">
                                            <span class="btn-inner--icon d-flex flex-row align-items-center me-2">
                                                <!-- Changed to flex-column for vertical stacking -->
                                                <i class="fa-sharp fa-solid far fa-building"
                                                    style="font-size: 0.75rem;margin-right:15%; color:#fff;"></i>
                                                <!-- Book icon below -->
                                                <i class="fa-sharp fa-solid fa-plus" style="color:#fff;"></i> <!-- Plus icon on top -->
                                            </span>
                                            <span class="btn-inner--text" style="color:#fff">Add Office</span>
                                        </button>
                                    </div>
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
                                <div class="input-group w-sm-25  grid grid-cols-1 ms-auto">
                                    <span class="input-group-text text-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                                @include('offices.partials.offices_table', [
                                    'offices' => $offices,
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
            url: "offices/manage",
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
