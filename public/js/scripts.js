'use strict';

(function($) {

    // Enable lazy loading for image tags
    $('img.lazy').lazyload({
        effect : 'fadeIn'
    });

    // Enables lazy loading on Ajax Requests
    $(document).ajaxStop(function(){
        $('img.lazy').lazyload({
            effect: 'fadeIn'
        }).removeClass('lazy');
    });

})(jQuery);