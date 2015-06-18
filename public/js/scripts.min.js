'use strict';

(function($) {

    var threshold = lazy_loading_options.threshold;

    // Enable lazy loading for image tags
    $('img.lazy').lazyload({
        threshold : threshold,
        effect : 'fadeIn'
    });

    // Enables lazy loading on Ajax Requests
    $(document).ajaxStop(function(){
        $('img.lazy').lazyload({
            threshold : threshold,
            effect: 'fadeIn'
        }).removeClass('lazy');
    });

})(jQuery);