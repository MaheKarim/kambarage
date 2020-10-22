
    <!-- sidenav left (dotted menu left) -->

    <div id="exlibris-sidenav-left" class="sidenav-l bg-side border-right">

        <div class="buttons-sidenav" id="topnav">

            <!-- close sidenav button -->
            <span title="Close Menu" class="closebtn toggle-open-close"><i class="fas fa-times fa-lg"></i></span>

        </div>

        <div class="sidenav-margin-top">
            <div class="sidenav-nav-container-res">
                <ul id="accordion" class="menu">
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.home')}}">Home</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.authors')}}">All Authors</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.books')}}">All books</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.books.recommended')}}">Recommended books</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.tac')}}">Terms and Conditions</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.pp')}}">Privacy Policy</a></li>
                    @auth
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.change-password')}}">Change password</a></li>
                    <li id="menu-item-348"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348 menu-hover"><a
                            href="{{route('web-client.user-logout')}}">Logout</a></li>
                    @endauth
                </ul>
            </div>
        </div>

    </div>
