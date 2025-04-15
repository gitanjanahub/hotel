<div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" target="_blank" class="brand-link">
            <img src="{{ asset('assets/images/RonaldCodesLogo.png') }}" alt="RonaldCodes Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">

            {{-- <a href="https://www.youtube.com/@RonaldCodes23" target="_blank"><img
                    src="{{ asset('assets/images/RonaldCodesLogo.png') }}" alt="Ronald Codes Logo"
                    class="brand-image img-circle elevation-3 rounded-circle cursor-pointer" style="width: 50px" />
            </a> --}}

            <span class="brand-text font-weight-light">Hotel</span>
        </a>

        <div class="sidebar">
            {{-- Sidebar user panel (optional)  --}}
            {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('assets/bms_logo.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>

                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div> --}}

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.banner') }}"
                           class="nav-link {{ request()->is('admin/banner') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-image"></i>
                            <p>Home Banner</p>
                        </a>
                    </li>


                    <!-- services -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.services') }}"
                           class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">
                            <i class="nav-icon fas fas fa-hotel"></i>
                            <p>Services</p>
                        </a>
                    </li>

                    <!-- Room Types -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.room-types') }}"
                           class="nav-link {{ request()->is('admin/room-types*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Room Types</p>
                        </a>
                    </li>

                    <!-- Rooms -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.rooms') }}"
                           class="nav-link {{ request()->is('admin/rooms*') ? 'active' : '' }}">
                            <i class="nav-icon fa fas fa-home"></i>
                            <p>Rooms</p>
                        </a>
                    </li>

                    <!-- Room Services -->
                    {{-- <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.room-services') }}"
                           class="nav-link {{ request()->is('admin/room-services*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-mars-double"></i>
                            <p>Room Services</p>
                        </a>
                    </li> --}}

                    <!-- Bookings -->
                    {{-- <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.bookings') }}"
                           class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>Bokkings</p>
                        </a>
                    </li> --}}

                    <li class="nav-item has-treeview {{ request()->is('admin/bookings*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>
                                Bookings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a wire:navigate href="{{ route('admin.bookings', ['status' => 'Confirmed']) }}"
                                   class="nav-link {{ request()->is('admin/bookings/confirmed') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Confirmed</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a wire:navigate href="{{ route('admin.bookings', ['status' => 'Pending']) }}"
                                   class="nav-link {{ request()->is('admin/bookings/pending') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a wire:navigate href="{{ route('admin.bookings', ['status' => 'Cancelled']) }}"
                                   class="nav-link {{ request()->is('admin/bookings/cancelled') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cancelled</p>
                                </a>
                            </li>
                        </ul>
                    </li>






                    {{-- <!-- Users -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.users') }}"
                           class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.about-us') }}"
                           class="nav-link {{ request()->is('admin/about-us') ? 'active' : '' }}">
                            <i class="nav-icon fas far fa-address-card"></i>
                            <p>About Us</p>
                        </a>
                    </li>

                    <!-- Gallery -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.galleries') }}"
                           class="nav-link {{ request()->is('admin/galleries*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Gallery</p>
                        </a>
                    </li>

                    <!-- Contact Us -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.company-details') }}"
                           class="nav-link {{ request()->is('admin/company-details') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-card"></i>
                            <p>Company Details</p>
                        </a>
                    </li>

                    <!-- Testimonials -->
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.testimonials') }}"
                           class="nav-link {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Testimonials</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a wire:navigate href="{{ route('admin.news-letter') }}"
                           class="nav-link {{ request()->is('admin/news-letter') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Newsletter Subscription</p>
                        </a>
                    </li>

                </ul>
            </nav>


        </div>
    </aside>

</div>
