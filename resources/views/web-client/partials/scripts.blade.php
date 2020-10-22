
    <script src='/wp-content/plugins/contact-form-7/includes/js/scripts38c6.js?ver=5.1.9'></script>
    <script src='/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min44fd.js?ver=2.70'></script>
    <script src='/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.minae82.js?ver=4.2.0'></script>
    <script src='/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min6b25.js?ver=2.1.4'></script>
    <script src='/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.minae82.js?ver=4.2.0'></script>
    <script src='/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.minae82.js?ver=4.2.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/bootstrap/bootstrap.bundle.min5b31.js?ver=4.3.1'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/mode5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/lightbox/ekko-lightbox.min5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/custom5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/navbar5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/bootstrap-drawer5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/pkgd/flickity.pkgd.mindc8c.js?ver=2.2'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/flickity-custom20b9.js?ver=1.0.2'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/wooalign-public5152.js?ver=1.0'></script>
    <script src='/wp-content/themes/exlibriswp/assets/js/pace/pace.min5152.js?ver=1.0'></script>
    <script src='/wp-includes/js/wp-embed.min7661.js?ver=5.4.2'></script>
    <script type="text/javascript">
        var c = document.body.className;
        c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
        document.body.className = c;
    </script>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var wc_cart_fragments_params = {
            "ajax_url": "\/projects\/exlibris\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/projects\/exlibris\/?wc-ajax=%%endpoint%%",
            "cart_hash_key": "wc_cart_hash_fd15fa741a71833ff4661959146e771c",
            "fragment_name": "wc_fragments_fd15fa741a71833ff4661959146e771c",
            "request_timeout": "5000"
        };
        /* ]]> */

    </script>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var woocommerce_params = {
            "ajax_url": "\/projects\/exlibris\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/projects\/exlibris\/?wc-ajax=%%endpoint%%"
        };
        /* ]]> */

    </script>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var wc_add_to_cart_params = {
            "ajax_url": "\/projects\/exlibris\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/projects\/exlibris\/?wc-ajax=%%endpoint%%",
            "i18n_view_cart": "View cart",
            "cart_url": "https:\/\/demo.ramsthemes.com\/projects\/exlibris\/cart\/",
            "is_cart": "",
            "cart_redirect_after_add": "no"
        };
        /* ]]> */

    </script>
    <script>
    function filterSubCategory(e){ 
        let sub_category_id = $(e).val();
        let category_id = $(e).children("option:selected").attr('data-category-id')
        let url = `{{route("web-client.books")}}?category_id=${category_id}&sub_category_id=${sub_category_id}`;
        window.location = url
    }
    </script>
