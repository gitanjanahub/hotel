<div>
    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            @if ($contactDetail->phone)
                            <li><i class="fa fa-phone"></i> {{ $contactDetail->phone }}</li>
                            @endif

                            @if ($contactDetail->email)
                            <li><i class="fa fa-envelope"></i> {{ $contactDetail->email }}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
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
                            <a href="#" class="bk-btn">Booking Now</a>
                            {{-- <div class="language-option">
                                <img src="img/flag.jpg" alt="">
                                <span>EN <i class="fa fa-angle-down"></i></span>
                                <div class="flag-dropdown">
                                    <ul>
                                        <li><a href="#">Zi</a></li>
                                        <li><a href="#">Fr</a></li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="/">
                                <img src="{{ asset('storage/' . $contactDetail->logo) }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
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

                                    {{-- <li><a href="./pages.html">Pages</a>
                                        <ul class="dropdown">
                                            <li><a href="./room-details.html">Room Details</a></li>
                                            <li><a href="./blog-details.html">Blog Details</a></li>
                                            <li><a href="#">Family Room</a></li>
                                            <li><a href="#">Premium Room</a></li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li><a href="./blog.html">News</a></li> --}}
                                    {{-- <li><a wire:navigate href="/contact-us">Contact</a></li> --}}
                                </ul>
                            </nav>
                            <div class="nav-right search-switch">
                                <i class="icon_search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
</div>
