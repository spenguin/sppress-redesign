/**
 * Javascript for Soaring Penguin Press theme
 * 
 */
jQuery(document).ready(function() {

    var elms = document.getElementsByClassName( 'splide' );
    for ( var i = 0, len = elms.length; i < len; i++ ) {
        new Splide( elms[ i ] ).mount();
    }    
});