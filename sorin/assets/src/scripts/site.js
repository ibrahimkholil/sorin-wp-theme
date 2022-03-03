
(function ($) {
	'use-strict';
    //***************************
    // Sticky Header Function
    //***************************
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 170) {
            jQuery('body').addClass("sorin-sticky");
        } else {
            jQuery('body').removeClass("sorin-sticky");
        }
    });
    //***************************
    // Preloader
    //***************************
    $(".sr-preloader").delay(1000).fadeOut("slow");

})(jQuery);