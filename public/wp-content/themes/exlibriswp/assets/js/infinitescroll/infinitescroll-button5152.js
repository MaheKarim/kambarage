

    // init Infinite Scroll

    $('.article-feed').infiniteScroll({
        path: '.paginationnav a.next',
        append: '.post',
        button: '.view-more-button',
        // using button, disable loading on scroll 
        history: false,
        scrollThreshold: false,
        status: '.page-load-status',
        hideNav: '.paginationnav',
    });

    // hide button when no next page
    var $nextLink = $('.paginationnav a.next');
    if (!$nextLink.length) {
        $('.view-more-button').hide();
    }



