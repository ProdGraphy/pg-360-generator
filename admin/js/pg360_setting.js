/**
 * setting page
 */
jQuery(document).ready(function($) {
    $('.pg360_color').wpColorPicker();

    $(function() {
        if ($('#pg360_watermark_chkbox').is(":checked")) {
            $("#pg360_watermark").prop('disabled', false);
        } else {
            $("#pg360_watermark").prop('disabled', true);
        };
    });

});