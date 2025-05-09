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
            <div class="language-option dropdown">
                <span class="dropdown-toggle text-capitalize" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  Account
                </span>
                <div class="flag-dropdown dropdown-menu">
                  <ul class="list-unstyled mb-0">
                    @guest
                    <li><a class="dropdown-item" data-toggle="modal" data-target="#loginModal">Login</a></li>
                    @endguest

                    @auth
                    <li><a class="dropdown-item mt-2" wire:navigate href="/logout">Logout</a></li>
                    @endauth
                  </ul>
                </div>
            </div>
            {{-- <livewire:auth.login-page/> --}}
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
            @if ($contactDetail->facebook)
                <a href="{{ $contactDetail->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
            @endif

            @if ($contactDetail->twitter)
                <a href="{{ $contactDetail->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
            @endif

            @if ($contactDetail->youtube)
                <a href="{{ $contactDetail->youtube }}" target="_blank"><i class="fa fa-youtube-play"></i></a>
            @endif

            @if ($contactDetail->instagram)
                <a href="{{ $contactDetail->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a>
            @endif

        </div>
        <ul class="top-widget">
            @if ($contactDetail->phone)
                <li><i class="fa fa-phone"></i> {{ $contactDetail->phone }}</li>
            @endif

            @if ($contactDetail->email)
                <li><i class="fa fa-envelope"></i> {{ $contactDetail->email }}</li>
            @endif
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->
</div>
