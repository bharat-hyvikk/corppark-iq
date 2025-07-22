<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start ps" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('dashboard') }}" target="_self">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('assets/img/corppark-logo.svg') }}" style="width: 59%; height:100%;object-fit:cover"
                    class="pb-1">
            </div>
        </a>
    </div>
    <div class=" px-4 w-auto ps ps--active-x" id="sidenav-collapse-main" style="margin-top:40px;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>dashboard</title>
                            <g id="dashboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="template" transform="translate(12.000000, 12.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <path class="color-foreground"
                                        d="M0,1.71428571 C0,0.76752 0.76752,0 1.71428571,0 L22.2857143,0 C23.2325143,0 24,0.76752 24,1.71428571 L24,5.14285714 C24,6.08962286 23.2325143,6.85714286 22.2857143,6.85714286 L1.71428571,6.85714286 C0.76752,6.85714286 0,6.08962286 0,5.14285714 L0,1.71428571 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M0,12 C0,11.0532171 0.76752,10.2857143 1.71428571,10.2857143 L12,10.2857143 C12.9468,10.2857143 13.7142857,11.0532171 13.7142857,12 L13.7142857,22.2857143 C13.7142857,23.2325143 12.9468,24 12,24 L1.71428571,24 C0.76752,24 0,23.2325143 0,22.2857143 L0,12 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M18.8571429,10.2857143 C17.9103429,10.2857143 17.1428571,11.0532171 17.1428571,12 L17.1428571,22.2857143 C17.1428571,23.2325143 17.9103429,24 18.8571429,24 L22.2857143,24 C23.2325143,24 24,23.2325143 24,22.2857143 L24,12 C24,11.0532171 23.2325143,10.2857143 22.2857143,10.2857143 L18.8571429,10.2857143 Z"
                                        id="Path"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->isManager || Auth::user()->user_type == '1')
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('users.manage') ? 'active' : '' }}"
                        href="{{ route('users.manage') }}">
                        <div
                            class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="fa-sharp fa-solid fa-users" style="font-size:15px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->isAdmin)
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('buildings.manage') ? 'active' : '' }}"
                        href="{{ route('buildings.manage') }}">
                        <div
                            class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="fa-sharp fa-solid fas fa-building" style="font-size:15px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Building Management</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('offices.manage') ? 'active' : '' }}"
                    href="{{ route('offices.manage') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-sharp fa-solid far fas fa-briefcase" style="font-size:15px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Office Management</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('vehicles.manage') ? 'active' : '' }}"
                    href="{{ route('vehicles.manage') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-sharp fa-solid fas fa-car-side" style="font-size:15px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Vehicle Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('qrcode.index') ? 'active' : '' }}"
                    href="{{ route('qrcode.index') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-sharp fa-solid fas fas fa-qrcode" style="font-size:15px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">QR Code Management</span>
                </a>
            </li>
            @if (auth()->user()->isAdmin)
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('users.profile') ? 'active' : '' }}"
                        href="{{ route('users.profile') }}">
                        <div
                            class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" class="ms-0"
                                viewBox="0 0 24 24" fill="#FFFFFF">
                                <path fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Update Profile</span>
                    </a>
                </li>
                @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="nav-link {{ is_current_route('logout') ? 'active' : '' }} btn btn-link">
                                <div
                                    class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>
                                <span class="nav-link-text ms-1">Logout</span>
                            </button>
                        </form>
                    </li>
    </ul>
    <div class="ps__rail-x" style="width: 250px; left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 248px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
    </div>
</div>
<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
</div>
<div class="ps__rail-y" style="top: 0px; right: 0px;">
    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
</div>
</aside>
