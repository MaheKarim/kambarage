function woolfwp_mode_js() {
    'use strict';

    function darkmode() {
        $('body').addClass('dark-mode');
        localStorage.setItem('mode', 'dark');
    }

    function nodark() {
        $('body').removeClass('dark-mode');
        localStorage.setItem('mode', 'light');
    }

    if (localStorage.getItem('mode') == 'dark')
        darkmode();
    else
        nodark();

    $('#mode').change(function() {

        if ($(this).prop('checked')) {
            darkmode();
        } else {
            nodark();
        }

    });

    // keep checked

    var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},
        $checkboxes = $('#topnav :checkbox');

    $checkboxes.on('change', function() {
        $checkboxes.each(function() {
            checkboxValues[this.id] = this.checked;
        });

        localStorage.setItem('checkboxValues', JSON.stringify(checkboxValues));
    });

    // On page load
    $.each(checkboxValues, function(key, value) {
        $('#' + key).prop('checked', value);
    });

};

jQuery(document).ready(function($) {
    'use strict';
    woolfwp_mode_js();
});