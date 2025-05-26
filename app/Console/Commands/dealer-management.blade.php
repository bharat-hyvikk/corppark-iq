<x-app-layout>

    <main class="main-content d-flex flex-column min-vh-100 position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName="Dealer Management" />
        </div>
        {{-- @include('DealerManage.model.view-dairy')
        @include('DealerManage.model.edit')
        @include('DealerManage.model.confirm') --}}
        @include('admins.dealers.models.add')
        @include('admins.dealers.models.edit')
        @include('admins.dealers.models.confirm')
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
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Total Dealer</h3>
                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $dealers->total() }}
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
                                    <h6 class="font-weight-semibold text-lg mb-0">Dealer list</h6>
                                    <p class="text-sm">See information about all dealer</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    {{-- <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button> --}}
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#dealerModal"
                                        class="btn btn-sm btn-icon d-flex align-items-center me-2" id="dealerModal"
                                        style="background-color:#735bfc">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2"
                                                style="color:#FFF">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text" style="color:#fff">Add Dealer</span>
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
                            <div class="table-responsive p-0" id="dealersTable">
                                @include('admins.dealers.partials.dealers_table', [
                                    'dealers' => $dealers,
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
        let u_type = $("[name='btnradiotable']:checked").val();
        $.ajax({
            type: "GET",
            url: "/admin/dealers-manage",
            data: {
                search: searchInput,
                itemsPerPage: itemsPerPage,
                page: $page,
            },
            success: function(response) {
                $('#dealersTable').html(response.table);
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
