/**
 * Customizer Live Preview
 */
(function($) {
    'use strict';

    // Hero Title
    wp.customize('bdc_hero_title', function(value) {
        value.bind(function(to) {
            $('.hero-title').text(to);
        });
    });

    // Hero Slogan
    wp.customize('bdc_hero_slogan', function(value) {
        value.bind(function(to) {
            $('.hero-slogan').text(to);
        });
    });

    // Hero Image
    wp.customize('bdc_hero_image', function(value) {
        value.bind(function(to) {
            if (to) {
                $('.hero-fallback').css('background-image', 'url(' + to + ')');
            }
        });
    });

    // WhatsApp Number (floating buttons)
    wp.customize('bdc_whatsapp', function(value) {
        value.bind(function(to) {
            if (to) {
                var clean = to.replace(/[^0-9]/g, '');
                $('.float-btn-whatsapp').attr('href', 'https://wa.me/' + clean);
            }
        });
    });

    // Email
    wp.customize('bdc_email', function(value) {
        value.bind(function(to) {
            if (to) {
                $('.float-btn-email').attr('href', 'mailto:' + to);
            }
        });
    });

})(jQuery);
