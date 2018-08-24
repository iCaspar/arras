jQuery(document).ready( function($) {
    $('#featured-slideshow').cycle({
        fx: 'fade',
        speed: 250,
        next: '#controls .next',
        prev: '#controls .prev',
        timeout: 6000,
        pause: 1,
        slideExpr: '.featured-slideshow-inner',
        height: slideshow_opts.height,
        width: '100%',
        fit: true
    });
} );
