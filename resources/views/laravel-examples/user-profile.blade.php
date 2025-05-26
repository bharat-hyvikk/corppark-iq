<x-app-layout>
    @push('title')
        Update Profile
    @endpush
    {{-- <style>
        .profile-pic{
           margin-top:5%;
        }
    </style> --}}
    <main class="main-content d-flex flex-column position-relative border-radius-lg ps min-vh-100 ">
        <div class="navbar-container flex-shrink-0">
            <x-app.navbar pageName="Update Profile" />
        </div>
        <div class="container-fluid py-4 px-5 flex-grow-1 wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background" style="background: linear-gradient(to right, #735bfc, #965bfc);">

                        </div>
                        <div class="card-body text-start p-4 w-100">
                            <div id="totalContainer">
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Name</h3>

                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $user->name }}
                                </p>
                                <h3 class="text-white mb-2" id="pageHeaderTitle">Email</h3>

                                <p class="mb-4 font-weight-semibold" id="pageHeaderText">
                                    {{ $user->email }}
                                </p>
                            </div>


                            <h3 class="text-white mb-2" id="search-msg"></h3>
                            <img src="{{ asset('assets/img/3D-object (2).png') }}" alt="3d-cube" {{-- <img src="{{ asset('assets/img/header-title-logo.svg') }}" alt="3d-cube" --}}
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
                <form action={{ route('admin.update') }} method="POST" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert" id="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success w-full" role="alert" id="alert">
                                    {{ session('success') }}
                                </div>
                                <script>
                                    // Set a timeout to hide the alert after 5 seconds
                                    setTimeout(function() {
                                        var alertElement = document.getElementById('alert');
                                        if (alertElement) {
                                            alertElement.style.opacity = 0;
                                            // Optional: Remove the alert element from the DOM after fade-out
                                            setTimeout(function() {
                                                alertElement.style.display = 'none';
                                            }, 600); // Adjust this time to match the fade-out duration
                                        }
                                    }, 5000); // 5000 milliseconds = 5 seconds
                                </script>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-12 col-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Profile Info</h5>
                                </div>
                                <div class="pt-0 card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $user->name) }}" class="form-control">
                                            @error('name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $user->email) }}" class="form-control">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="phone">Phone No</label>
                                            <input type="tel" name="phone" id="phone"
                                                value="{{ old('phone', $user->phone) }}" class="form-control">
                                            @error('phone')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if (auth()->user()->user_type == '0')
                                            <div class="col-6">
                                                <label for="phone">Password</label>
                                                <input type="tel" name="password" id="password"
                                                    class="form-control">
                                                @error('password')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif

                                    </div>
                                    <button type="submit"
                                        class="btn-dark mt-5 mb-0 btn btn-btn-primary btn-sm float-center"
                                        id="userUpdate">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <x-app.footer />
    </main>

</x-app-layout>
