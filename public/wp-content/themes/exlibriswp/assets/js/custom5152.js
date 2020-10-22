
(function($, window, document, undefined) {
    'use strict';
			
    // Back to top button

    if ($('#back-to-top , #back-to-home').length) {
        var scrollTrigger = 100, // px
            backToTop = function() {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top , #back-to-home').addClass('show');
                } else {
                    $('#back-to-top , #back-to-home').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function() {
            backToTop();
        });
        $('#back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }    

    // Toggle open and close sidenav

    $('.toggle-open-close').click(function() {
        $("#exlibris-sidenav-left").toggleClass("sidenav-w");
    });
	
	$('.toggle-open-close-right').click(function() {
		$("#exlibris-sidenav-right").toggleClass("sidenav-w-right");
    });

    // Gallery Lightbox modify arrows

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            leftArrow: '<span><i class="fas fa-angle-left"></i></span>',
            rightArrow: '<span><i class="fas fa-angle-right"></i></span>',
        });
    });

    // Add custom classes to predefined targets	
    	
	$('.woocommerce-review__verified, .coupon input.input-text, .wpcf7-form-control').addClass('border-class');	
	$('.wpcf7 input[type="submit"], .wpcf7 input[type="button"]').addClass('btn btn-custom btn-lg btn-block');	
	$('.wpua-edit p.submit input.button').addClass('btn btn-block border-class');	
	$('.woocommerce-notices-wrapper a.button.wc-forward').addClass('btn btn-custom rounded-pill float-right mr-3');	
	$('.reset_variations').addClass('btn btn-custom btn-sm');
	$('.product_meta > .prodcats a').addClass('btn btn-custom btn-sm mr-1 mb-1');
	$('.product_meta > .prodtags a').addClass('btn btn-info btn-sm mr-1 mb-1');
	$('.woocommerce .size-woocommerce_thumbnail, img.woocommerce-placeholder, img.attachment-woocommerce_thumbnail').addClass('shadow-sm');	
	
	// Active woo tab 	
    
	$("#wooTab a:first").addClass('active');
	$(".tab-pane:first").addClass('show active');	

    // Full screen search

    $(function() {
        $('a[href="#search"]').on('click', function(event) {
            event.preventDefault();
            $('#search').addClass('open');
            $('#search > form > input[type="search"]').focus();
        });

        $('#search, #search button.close').on('click keyup', function(event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
        });
    });	

	// Sidebar collapse	
	
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });    
			
	// Navbar collapse
	
	$('.navbar-collapse a').click(function(){
	  $(".navbar-collapse").collapse('hide');
	});

})(jQuery, window, document);