<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="mediaDialogue">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="mediaModalLabel">
                    <span>Building Name:</span>
                    <span id="building_name" class="text-capitalize"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 p-0" id="mediaContainer">
                <!-- Media content will be inserted here by JavaScript -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.media-icon', function() {
            const id = $(this).data('id');
            // const mediaSrc = $(this).data('media-src');

            // let mediaSrc = $(this).data('media-src');
            let building_name = $(this).data('building_name');
            $("#building_name").text(building_name);
            let mediaSrc = $(this).attr("data-media-src");
            console.log(mediaSrc);
            let ele = $("#dairy-" + id + " .media-icon ")


            const mediaContainer = $('#mediaContainer');
            let mediaElement;
            mediaElement =
                `<img src="${mediaSrc}" type="image" class="w-100"  style="height:300px;object-fit:contain;object-position:center; padding:16px;" =>`;
            // if(mediaType!=="PDF"){
            //     mediaContainer.removeClass('modal-fullscreen-sm-down')
            // }

            mediaContainer.html(mediaElement);
            $('#mediaModal').modal('show');
        });
    });
</script>
