<div>
    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        <div class="search-icon  search-switch">
            <i class="icon_search"></i>
        </div>
        <div class="header-configure-area">
            {{-- <div class="language-option">
                <img src="{{ asset('fronttheme/img/flag.jpg') }}" alt="">
                <span>EN <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                    <ul>
                        <li><a href="#">Zi</a></li>
                        <li><a href="#">Fr</a></li>
                    </ul>
                </div>
            </div> --}}
            <a href="#" class="bk-btn">Booking Now</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                    <a wire:navigate href="{{ route('home') }}">Home</a>
                </li>
                <li class="{{ Route::currentRouteName() === 'rooms' ? 'active' : '' }}">
                    <a wire:navigate href="{{ route('rooms') }}">Rooms</a>
                </li>
                <li class="{{ Route::currentRouteName() === 'about' ? 'active' : '' }}">
                    <a wire:navigate href="{{ route('about') }}">About Us</a>
                </li>
                <li class="{{ Route::currentRouteName() === 'contact' ? 'active' : '' }}">
                    <a wire:navigate href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-tripadvisor"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i> (12) 345 67890</li>
            <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->
</div>
