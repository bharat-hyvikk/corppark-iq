{{-- <footer class="footer p-5 ">
    <div class="row align-items-center justify-content-lg-between ">
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-m text-muted text-lg-start">
                Copyright
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>
               Alankar Learning Portal
            </div>
        </div>
        <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                    <a href="https://www.creative-tim.com" class="nav-link text-m text-muted" target="_blank">Creative
                        Tim</a>
                </li>
                <li class="nav-item">
                    <a href="https://www.updivision.com" class="nav-link text-m text-muted"
                        target="_blank">UPDIVISION</a>
                </li>
                <li class="nav-item">
                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-m text-muted"
                        target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="https://www.creative-tim.com/blog" class="nav-link text-m text-muted"
                        target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="https://www.creative-tim.com/license" class="nav-link text-m pe-0 text-muted"
                        target="_blank">License</a>
                </li>
            </ul>
        </div>
    </div>
</footer> --}}
<style>
.text-reset:hover {
    color:  #0d6efd !important; /* Change text color to blue on hover */
}
/* .footer{ */
    /* position:fixed; */
/* } */
</style>
<footer class="px-5" style="bottom: 0; position:sticky">
        <div class="d-flex align-items-start ">
            <div class="mb-2">
                <div class="copyright text-center text-xs text-muted text-lg-start">
                    Copyright
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    {{ config("app.name") }}
                    {{-- <a href="https://www.creative-tim.com" class="text-secondary" target="_blank">Portal</a>. --}}
                </div>
            </div>
            <div class="mb-2 ms-auto">
                <p class=" text-xs text-muted text-center">Powered By <a href="https://hyvikk.com/" class="text-reset" target="_blank" style="hover">
                         Hyvikk Solutions
                    </a>
                 </p>
            </div>
        </div>
    
</footer>
