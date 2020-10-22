
    <div id="exlibris-sidenav-right" class="sidenav-r bg-side border-left">

        <div class="buttons-sidenav" id="topnav"> 

            <!-- login -->
            <label class="pointerbtn">
                <a title="Login" href="{{route('login')}}"><i class="fas fa-sign-in-alt fa-lg"></i></a>
            </label>



            <!-- close sidenav button -->
            <span title="Close Menu" class="closebtn toggle-open-close-right"><i class="fas fa-times fa-lg"></i></span>

        </div>

        <div class="sidenav-margin-top">
            <div data-simplebar class="scrollbar-sidenav-res">

                <!-- Shop sidebar and account sidebar-->

                <div class="sidenav-nav-container">
                    <div id="nav_menu-2" class="widget_nav_menu mb-3">
                        <div class="menu-sidenav-menu-container">
                            @include('web-client.partials.categories-nav')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
