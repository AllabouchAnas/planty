(function ($) {
    "use strict";
    $(document).ready(function () {
        $( '#post-like .edit-post-like' ).on('click',function (event) {
            event.preventDefault();
            if ( $( '#post-like-input-container' ).is( ":hidden" ) ) {
                $( '#post-like-input-container' ).slideDown( 'fast' );
                $( this ).hide();
            }
        });


        $( '#post-like .cancel-post-like' ).on('click',function (event) {
            event.preventDefault();
            $( '#post-like-input-container' ).slideUp( 'fast' );
            $( '#post-like .edit-post-like' ).show();
        });


        $( '#post-like .save-post-like' ).on('click',function (event) {
            $( '#post-like-input-container' ).slideUp( 'fast' );
            $( '#post-like .edit-post-like' ).show();

            var views = parseInt( $( '#post-like-input' ).val() );
            // reassign value as integer
            $( '#post-like-input' ).val( views );

            $( '#post-like-display b' ).text( views );

            return false;
        });


    });

})(jQuery);