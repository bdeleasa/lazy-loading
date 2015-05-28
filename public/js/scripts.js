'use strict';

(function($) {

    // Enable lazy loading for image tags
    // @todo add a settings page for these params
    $('img.lazy').lazyload({
        threshold : 200,
        effect : 'fadeIn'
    });

    // Enables lazy loading on Ajax Requests
    $(document).ajaxStop(function(){
        $('img.lazy').lazyload({
            threshold : 200,
            effect: 'fadeIn'
        }).removeClass('lazy');
    });

})(jQuery);