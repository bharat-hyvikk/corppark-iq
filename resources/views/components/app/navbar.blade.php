<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded overflow-hidden" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark Dash-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageName }}</li>
            </ol>
            <h6 class="font-weight-bold mb-0">{{ $pageName }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="d-flex align-items-center ms-auto flex-nowrap">
                <ul class="navbar-nav me-3">
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-end">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                </ul>
                <div>
                    @if (auth()->user()->isAdmin)
                        <span class="profile text-nowrap">
                            {{ auth()->user()->name }}
                        </span>
                    @else
                        <span class="profile text-nowrap">
                            {{ auth()->user()->name }}|{{ auth()->user()->building->building_name }}
                        </span>
                    @endif

            </div>
        </div>
    </div>
</div>
</nav>
