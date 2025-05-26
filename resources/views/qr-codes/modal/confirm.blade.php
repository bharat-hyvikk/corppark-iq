<!-- Delete Confirmation Modal -->
<div class="modal fade" id="generateQRModal" tabindex="-1" aria-labelledby="generateQRModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateQRModalLabel">Generate Bulk QR</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to generate bulk QR?</p>
            </div>
            <div class="modal-footer">
                <form id="qrForm" method="get" class="d-flex justify-content-between">
                    @csrf
                    <!-- The buttons should be inside the form -->
                    <button type="submit" id="generate-qr-btn-modal"
                        class="btn btn-sm btn-primary btn-icon me-2 d-flex align-items-center">
                        <span class="btn-inner--icon">
                            <i class="fa-sharp fa-solid fa-qrcode"
                                style="font-size: 0.75rem; margin-right: 0.2rem;"></i>
                        </span>
                        <i class="fa-solid fa-spinner fa-spin"
                            style="display: none; font-size: 0.75rem; margin-right: 0.2rem;"></i>
                        <span class="btn-inner--text">Generate</span>
                        <input type="hidden" value="{{ request()->query('id') }}" name="officeId">
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
