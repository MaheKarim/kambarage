@php
    $search_term = request()->has("s")?request()->s:null;
@endphp
<nav class="fixed-header navbar navbar-height navbar-pos bg-navbar border-bottom">

    <div class="navbar-container position-relative">

        <!-- hamburger menu left-->
        <span class="hamb-menu toggle-open-close"><i class="fas fa-th fa-lg mx-2 v-middle"></i></span>
        <a class="navbar-logo-left" href="{{route('web-client.home')}}">
            <!-- display logo for normal mode -->
            <img class="logo logow logores" src="/wp-content/logo-new.png"
                alt="Normal Mode Logo">
            <!-- display logo for dark mode -->
            <img class="logo logob logores" src="/wp-content/logo-new.png"
                alt="Dark Mode Logo">
            <!-- display logo for normal mode -->
            <img class="logo logow d-md-none" src="/wp-content/logo-new.png"
                alt="Normal Mode Logo">
            <!-- display logo for dark mode -->
            <img class="logo logob d-md-none" src="/wp-content/logo-new.png"
                alt="Dark Mode Logo">
        </a>
        <!-- display search bar below -->
        <div class="customsearch">

        <form role="search" method="get" id="searchres" action="{{route('web-client.books.search')}}">
            @csrf
            <input class="rounded-left" id="search-input-res" value="{{$search_term??null}}" name="s" placeholder="Search Books"
                role="search" type="search">
            <button class="rounded-right" aria-label="submit" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
        </div>

        <!-- icons on right -->

        <div class="navbar-icons">
            <!-- login -->
            {{-- <div class="d-none d-md-inline-block">
                <a title="Login" href="#"><i
                        class="fas fa-sign-in-alt fa-lg v-middle mx-2"></i></a>
            </div> --}}
            <div class="navbar-box" id="topnav">
                <!-- Switch mode -->
                <label for="mode" title="Switch Light/Dark mode"
                    class="switch-checkbox icon-align-bottom mx-1 d-inline-block"><input id="mode"
                        type="checkbox"><i class="fas fa-moon fa-lg v-middle unchecked"></i><i
                        class="far fa-moon fa-lg v-middle checked"></i></label>
                <!-- hamburger menu right -->
                <div class="hamb-menu-right-box d-inline-block d-md-none">
                    <span class="toggle-open-close-right"><i
                            class="fas fa-bars fa-lg hamb-menu-right v-middle"></i></span>
                </div>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-search bg-navbar border-bottom">
    <!-- display search bar responsive -->
    <div class="customsearch-res">
        <form role="search" method="get" id="searchres" action="{{route('web-client.books.search')}}">
            @csrf
            <input class="rounded-left" id="search-input-res" value="{{$search_term??null}}" name="s" placeholder="Search Books"
                role="search" type="search">
            <button class="rounded-right" aria-label="submit" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
</nav>
