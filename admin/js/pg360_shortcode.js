(function($) {
    $(function() {

        //Cancel Button Function
        $('#pg360Cancel').click(function() {
            tb_remove();
        })

        //Insert Button Function
        $('#pg360Insert').click(function() {

            var pg360SelectedProject = $('.pg360_insert_chkbx:checked').map(function() {
                return $(this).val();
            }).get();

            if (pg360SelectedProject == "") {} else {
                for (var i = 0; i < pg360SelectedProject.length; i++) {
                    window.parent.send_to_editor('[prodgraphy-' + pg360SelectedProject[i] + ']');
                }
                tb_remove();
            }
        });

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
    });
})(jQuery);