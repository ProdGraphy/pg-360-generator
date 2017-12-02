jQuery(document).ready(function($) {

    /* 
     * 1st Step
     * Project Form AJAX
     */
    $('#pg360Form').submit(function() {
        $.ajax({
            url: pg360Param.update,
            type: 'post',
            success: function() {
                $('#pg360Form').hide();
                $('#pg360Dz').show();
            },
            error: function() {
                alert('Some thing wrong contact plugin author -> ProdGraphy.com');
            },
        });
    });

    /**
     * 2nd step
     * DropZone AJAX -> upload images and insert it's URL into database
     */

    // Disabling autoDiscover, otherwise Dropzone will try to attach twice.
    Dropzone.autoDiscover = false;

    //Now we will use jQuery to bind our configuration with the element.
    $("#pg360-media-uploader").dropzone({

        url: pg360Param.upload,
        acceptedFiles: 'image/*',
        success: function(file, response) {
            file.previewElement.classList.add("dz-success");
            file['attachment_id'] = response; // push the id for future reference
            var ids = $('#media-ids').val() + ',' + response;
            $('#media-ids').val(ids);
        },
        error: function(file, response) {
            file.previewElement.classList.add("dz-error");
        },
        // update the following section is for removing image from library
        addRemoveLinks: true,
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 1,
        dictDefaultMessage: "<a class='dzTxt'>Drop files here to upload or click <a></br><strong style='color:red'> Arrange Image Files By Name Before Upload</strong></br><button class='dzBtn'>Upload Files</button>",

        removedfile: function(file) {
            var attachment_id = file.attachment_id;
            $.ajax({
                type: 'POST',
                url: pg360Param.delete,
                data: {
                    media_id: attachment_id,
                    action: 'pg360_handle_deleted_media',
                },
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    });


    /**  
     * 3rd Step
     * reel 360 AJAX -> project preview after 360 
     */
    $('#next2').on('click', function() {
        $.ajax({
            url: pg360Param.pg360Reel,
            type: 'POST',
            data: {
                action: 'pg360_handle_reel',
            },
            success: function(response) {
                $('#pg360Dz').hide();
                $('#pg360Form').hide();
                window.location.replace('admin.php?page=pg-360-generator/admin/partials/pg360_gallery.php');
            },
            error: function() {
                alert('Some thing wrong contact at ProdGraphy.com')
            }
        })
    })
});