/**
 * Main Theme Scripts
 *
 * @package Layers2025
 * @since 1.0.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Add your custom JavaScript here

        // Example: Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                    return false;
                }
            }
        });

        // Add sticky header on scroll (example)
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky');
            } else {
                $('.site-header').removeClass('sticky');
            }
        });

    });

})(jQuery);
