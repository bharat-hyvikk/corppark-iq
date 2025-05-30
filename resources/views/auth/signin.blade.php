<x-guest-layout>
    @push('title')
        Sign In
    @endpush
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-5">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <img src="{{ asset('assets/img/corpark-login-logo.png') }}" alt=""
                                        style="width: 50%;" class="mb-3">

                                    <h3 class="font-weight-black text-dark display-6">Welcome</h3>
                                    <p class="mb-0">Sign In to access Portal<br></p>
                                </div>
                                <div class="card-body">
                                    <div class="text-start">
                                        @if (session('status'))
                                            <div class="text-capitalize alert alert-success text-sm text-capatalize"
                                                role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        @error('message')
                                            <div class="text-capitalize alert alert-danger text-sm text-capatalize"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <form role="form" class="text-start" method="POST" action="sign-in">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input type="text" id="email" name="email" class="form-control"
                                                placeholder="Enter Email" value="{{ old('email') ? old('email') : '' }}"
                                                aria-label="Email" aria-describedby="email-addon">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-4 position-relative">
                                            <input type="password" id="password" name="password" value=""
                                                class="form-control" placeholder="Enter password" aria-label="Password"
                                                aria-describedby="password-addon">
                                            <i class="fas fa-eye position-absolute" id="togglePassword"
                                                style="cursor: pointer; right: 30px; top: 50%; transform: translateY(-50%); font-size:14px;"></i>
                                            @error('password')
                                                <span class="text-danger text-sm "
                                                    style="position: absolute; bottom: -20px;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-check-info text-left mb-0">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="flexCheckDefault" name="rememberMe"
                                                    value="{{ old('rememberMe') }}">
                                                <label class="font-weight-normal text-dark mb-0" for="flexCheckDefault">
                                                    Remember Me
                                                </label>
                                            </div>
                                            {{-- <a href="{{ route('password.request') }}"
                                                class="text-xs font-weight-bold ms-auto">Forgot
                                                password</a> --}}
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center">
                                    <h6 class="text-dark text-sm">Copyright © {{ date('Y') }}
                                        {{ config('app.name') }}</h6>
                                    <h6 class="text-dark text-xs mt-1">Powered By<a href="https://hyvikk.com/"
                                            target="_blank">
                                            Hyvikk Solutions
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                                    style="background-image:url('../assets/img/login imag bg .png')">
                                    <div
                                        class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                                        <h2 class="mt-3 text-dark font-weight-bold">Smart Parking Starts with a Scan.
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#togglePassword").addEventListener("click", function() {
            const passwordField = document.querySelector("#password");
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
            this.classList.toggle("fa-eye");
        })
    });
</script>
