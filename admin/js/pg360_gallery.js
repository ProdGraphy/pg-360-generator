/*
 * These file handle AJAX for Gallery page Edit / Delete
 */
(function($) {
    'use strict';
    $(function() {

        /**-----------------------------------------------
         *                  Edit in Gallery
        --------------------------------------------------*/
        $(".pg360_edit").on('click', function() {

            var pg360EditClickedID = $(this).parent('div').prop('id');
            $('div#' + pg360EditClickedID).children('div').toggle();

            $('#pg360_form' + pg360EditClickedID).on('submit', function() {

                $.ajax({
                    url: pg360Project.edit,
                    type: "post",
                    action: 'pg360_project_edit',
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        alert('Something Wrong!! contact ProdGraphy.com')
                    },

                });
            });
        });

        /**
         * Delete in Gallery
         */
        $(".pg360_delete").on('click', function() {
            var pg360DelClickedID = $(this).parent('div').prop('id');

            if (window.confirm('You are going to delete this Project permanently') == true) {
                $('div#' + pg360DelClickedID).parent('div').hide();
                $.ajax({
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    url: pg360Project.delete,
                    type: "post",
                    data: {
                        pg360DelClickedID: pg360DelClickedID,
                        action: 'pg360_project_delete'
                    },
                    success: function() {
                        $('div#' + pg360DelClickedID).parent('div').hide();
                        $('.loader').hide();
                    },

                });
            }

        })

    });
})(jQuery);