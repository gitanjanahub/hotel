<div>
    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="/">
                                    <img src="{{ asset('storage/' . $contactDetail->footer_logo) }}" alt="">
                                </a>
                            </div>
                            @if ($contactDetail->description)
                            <p>{{ $contactDetail->description }}</p>
                            @endif
                            <div class="fa-social">
                                @if ($contactDetail->facebook)
                                    <a href="{{ $contactDetail->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
                                @endif

                                @if ($contactDetail->twitter)
                                    <a href="{{ $contactDetail->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
                                @endif

                                @if ($contactDetail->youtube)
                                    <a href="{{ $contactDetail->youtube }}"  target="_blank"><i class="fa fa-youtube-play"></i></a>
                                @endif

                                @if ($contactDetail->instagram)
                                    <a href="{{ $contactDetail->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                @if ($contactDetail->phone)
                                <li><i ></i> {{ $contactDetail->phone }}</li>
                            @endif

                            @if ($contactDetail->email)
                                <li><i></i> {{ $contactDetail->email }}</li>
                            @endif

                                @if ($contactDetail->address)
                                <li><i></i> {{ $contactDetail->address }}</li>
                            @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>New latest</h6>
                            <p>Get the latest updates and offers.</p>
                            <livewire:newsletter-subscription />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <ul>
                            <li><a wire:navigate href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a wire:navigate href="{{ route('about') }}">About Us</a></li>
                            <li><a wire:navigate href="{{ route('rooms') }}">Rooms</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                               Copyright &copy;2025
                               All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                               <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->

</div>


