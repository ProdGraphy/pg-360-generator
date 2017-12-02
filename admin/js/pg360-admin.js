(function($) {
    $(function() {

        /* 
         * Toggle less-more options:
         */
        $('#more-btn').on('click', function() {
            $('.more-option').toggle("slow");
            if ($('.more-option').show()) {
                $('.pg360-row-two').css('display', 'inline-block')
            }
            $(this).text(function(i, text) {
                return text === "- Less options" ? "+ More Options" : "- Less options";
            });
        })

        /* 
         * Interaction Control:
         */
        $('#pg360_interactive').click(function() {
            if ($('#pg360_interactive').is(":checked")) {

                $('.interaction').prop('disabled', false);
                $('.interaction_class').css("color", "black");

            } else {

                $('.interaction').prop('disabled', true);
                $('.interaction_class').css("color", "gray");
            }

        })

        /*
         * Hint
         */

        $('#pg360_hint_input').prop('disabled', true);

        $('#pg360_hint').click(function() {

            if ($('#pg360_hint').is(":checked")) {

                $('#pg360_hint_input').prop('disabled', false);

            } else {

                $('#pg360_hint_input').prop('disabled', true);
            }
        })

    });
})(jQuery);