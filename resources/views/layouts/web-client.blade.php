<!DOCTYPE html>
<html lang="en-US">
@include('web-client.partials.head')

<body class="home blog bg theme-exlibriswp woocommerce-no-js post-the-life-of-captain-marvel-trailer-released"
    id="loadfade"
    class="post-194 post type-post status-publish format-standard has-post-thumbnail hentry category-releases tag-captain-marvel tag-carol-danvers tag-comics tag-marvel book_author-margaret-stohl">

    @include('web-client.partials.header')
    @include('web-client.partials.side-nav')
    @include('web-client.partials.mobile-nav')
    <main class="pt-fixed">
        <div class="container-fluid">
            <div class="wrapper">
                <nav id="sidebar">
                    <div data-simplebar class="wc-navigation-sticky-top scrollbar-sidenav">
                        <div class="sidenav-nav-container">
                            <div id="nav_menu-2" class="widget_nav_menu mb-3">
                                <div class="menu-sidenav-menu-container">
                                    @include('web-client.partials.categories-nav')
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                @yield('content')
            </div>
        </div>
        @include('web-client.partials.footer')
        <a href="#" id="back-to-top" class="btn-custom" title="Back to top"><i class="fas fa-chevron-up"></i></a>
    </main>
    @include('web-client.partials.scripts')
</body>

</html>
