<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="mediaDialogue">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="mediaModalLabel">QR</h5>
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 p-0" id="mediaContainer">
                <!-- Media content will be inserted here by JavaScript -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '.media-icon', function() {
            let mediaSrc = $(this).data('media-src'); // QR code image source
            let vehicleNumber = $(this).data('vehicle-number'); // Book name

            // Set modal title with book name
            $('#mediaModalLabel').text(`Vehicle Number : ${vehicleNumber}`)

            // Insert the media (QR image) dynamically
            let mediaElement = `<img src="${mediaSrc}" type="image" class="w-100" style="height:300px;padding:16px;object-fit:contain;object-position:center;">`;

            // Display the media content inside the modal
            $('#mediaContainer').html(mediaElement);

            // Show the modal
            $('#mediaModal').modal('show');
        });
    });
</script>
