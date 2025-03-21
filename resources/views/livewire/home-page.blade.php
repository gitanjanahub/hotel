<div>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    @if($banner)
                        <div class="hero-text">
                            <h1>{{ $banner->title }}</h1>
                            <p>{{ $banner->description }}</p>
                            {{-- <a href="#" class="primary-btn">Discover Now</a> --}}
                        </div>
                    @endif
                </div>

                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Booking Your Hotel</h3>
                        <form action="#">
                            <div class="check-date">
                                <label for="date-in">Check In:</label>
                                <input type="text" class="date-input" id="date-in">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Check Out:</label>
                                <input type="text" class="date-input" id="date-out">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="guest">Guests:</label>
                                <select id="guest">
                                    <option value="">2 Adults</option>
                                    <option value="">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="room">Room:</label>
                                <select id="room">
                                    <option value="">1 Room</option>
                                    <option value="">2 Room</option>
                                </select>
                            </div>
                            <button type="submit">Check Availability</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($banner && !empty($banner->images))
            <div class="hero-slider owl-carousel">
                @foreach($banner->images as $image)
                    <div class="hs-item set-bg" data-setbg="{{ asset('storage/' . $image) }}"></div>
                @endforeach
            </div>
        @endif
    </section>
    <!-- Hero Section End -->



    <!-- About Us Section Begin -->
    @if($aboutus)
        <section class="aboutus-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-text">
                            <div class="section-title">
                                <span>About Us</span>
                                <h2>{{ $aboutus->home_title }}</h2>
                            </div>
                            <p>{{ $aboutus->home_content }}</p>
                            <a href="#" class="primary-btn about-btn">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if($aboutus && !empty($aboutus->home_images))
                            <div class="about-pic">
                                <div class="row">
                                    @foreach(array_slice($aboutus->home_images, 0, 2) as $ab_image)
                                        <div class="col-sm-6">
                                            <img src="{{ asset('storage/' . $ab_image) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- About Us Section End -->

    <!-- Services Section End -->
    @if($services)
        <section class="services-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>What We Do</span>
                            <h2>Discover Our Services</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-4 col-sm-6">
                            <div class="service-item">
                                {{-- <i class="flaticon-036-parking"></i> --}}
                                <h4>{{ $service->name }}</h4>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    @if($rooms)
        <section class="hp-room-section">
            <div class="container-fluid">
                <div class="hp-room-items">
                    <div class="row">
                        @foreach($rooms as $room)
                            <div class="col-lg-3 col-md-6">
                                <div class="hp-room-item set-bg" data-setbg="{{ asset('storage/' . $room->image) }}">
                                    <div class="hr-text">
                                        <h3>{{ $room->name }}</h3>
                                        <h2>{{  Number::currency($room->price_per_night , 'INR') }}<span>/Pernight</span></h2>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="r-o">Size:</td>
                                                    <td>{{ $room->size }} sqm</td>
                                                </tr>
                                                <tr>
                                                    <td class="r-o">Capacity:</td>
                                                    <td>{{ $room->capacity }} persons</td>
                                                </tr>
                                                <tr>
                                                    <td class="r-o">Bed:</td>
                                                    <td>{{ $room->bed }}</td>
                                                </tr>
                                                @if($room->roomServices->isNotEmpty())
                                                <tr>
                                                    <td class="r-o">Services:</td>
                                                    <td>
                                                        {{ $room->roomServices->pluck('name')->join(', ') }}
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <a href="/rooms/{{ $room->slug }}" class="primary-btn">More Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    @if($testimonials)
        <section class="testimonial-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Testimonials</span>
                            <h2>What Customers Say?</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="testimonial-slider owl-carousel">
                            @foreach($testimonials as $testimonial)
                                <div class="ts-item">
                                    <p>{{ $testimonial->content }}</p>
                                    <div class="ti-author">
                                        {{-- <div class="rating">
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star-half_alt"></i>
                                        </div> --}}
                                        <h5> - {{ $testimonial->name }}</h5>
                                    </div>
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Testimonial Section End -->

    <!-- Blog Section Begin -->
    @if($galleries)
        <section class="blog-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Hotel News</span>
                            <h2>Gallery</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($galleries as $gallery)
                        <div class="col-lg-4">
                            <div class="blog-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                                {{-- <div class="bi-text">
                                    <span class="b-tag">Travel Trip</span>
                                    <h4><a href="#">Tremblant In Canada</a></h4>
                                    <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                                </div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Blog Section End -->







</div>
