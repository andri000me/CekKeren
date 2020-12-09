/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    /* Ribbon subtitle */
    wp.customize( 'clarina_ribbon_subtitle', function(value) {
        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.ribbon-subtitle-wrap' ).removeClass( 'llorix_one_lite_only_customizer' );
            } else {
                $( '.ribbon-subtitle-wrap' ).addClass( 'llorix_one_lite_only_customizer' );
            }
            $( '.ribbon-subtitle-wrap' ).text( to );

        } );
    });

    /* ribbon image */
    wp.customize( 'clarina_ribbon_image',function(value) {
        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.ribbon-image-wrap' ).removeClass( 'llorix_one_lite_only_customizer' );
                $( '.ribbon-image-wrap img' ).attr('src', to);
            } else {
                $('.ribbon-image-wrap').addClass( 'llorix_one_lite_only_customizer' );
            }

        });
    });
    
    /* latest news subtitle */
    wp.customize( 'clarina_news_subtitle', function(value) {

        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.latest-news-subtitle-wrap' ).removeClass( 'llorix_one_lite_only_customizer' );
            } else {
                $( '.latest-news-subtitle-wrap' ).addClass( 'llorix_one_lite_only_customizer' );
            }
            $( '.latest-news-subtitle-wrap' ).text( to );

        } );
    });

    /* Featured ribbon title */
    wp.customize( 'clarina_featured_ribbon_title', function(value) {

        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.stats .section-header' ).removeClass( 'llorix_one_lite_only_customizer' );
            } else {
                $( '.stats .section-header' ).addClass( 'llorix_one_lite_only_customizer' );
            }
            $( '.stats .section-header h2' ).text( to );

        } );
    });


} )( jQuery );