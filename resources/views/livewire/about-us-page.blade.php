<div>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>About Us</h2>
                        <div class="bt-option">
                            <a href="/">Home</a>
                            <span>About Us</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ap-title">
                            <h2>{{ $aboutus->title }}</h2>
                            <p>{{ $aboutus->description }}</p>
                        </div>
                    </div>
                    @if($services)
                        <div class="col-lg-5 offset-lg-1">
                            <ul class="ap-services">
                                @foreach($services as $service)
                                  <li><i class="icon_check"></i> {{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @if(!empty($aboutus->images))
                <div class="about-page-services">
                    <div class="row">
                        @foreach($aboutus->images as $image)
                        <div class="col-md-4">
                            <div class="ap-service-item set-bg" data-setbg="{{ asset('storage/' . $image) }}">
                                {{-- <div class="api-text">
                                    <h3>Restaurants Services</h3>
                                </div> --}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
    <!-- About Us Page Section End -->

    @if($aboutus->video_url)

    <!-- Video Section Begin -->
    <section class="video-section set-bg" data-setbg="{{ asset('storage/' . $aboutus->video_thumb) }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>{{ $aboutus->video_title }}</h2>
                        <p>{{ $aboutus->video_description }}</p>
                             @if($aboutus && $aboutus->video_url)
                                <a href="{{ $aboutus->video_url }}" class="play-btn video-popup">
                                    <img src="{{ asset('fronttheme/img/play.png')}}" alt="">
                                </a>
                            @else
                                <p>No video available</p>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endif
    <!-- Video Section End -->

    <!-- Gallery Section Begin -->
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Gallery</span>
                        <h2>Discover Our Work</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($galleries as $index => $gallery)
                    @if ($index == 0)
                        <div class="col-lg-6">
                            <div class="gallery-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                                <div class="gi-text">
                                    <h3>Room Luxury</h3>
                                </div>
                            </div>
                            <div class="row">
                    @elseif ($index == 1 || $index == 2)
                                <div class="col-sm-6">
                                    <div class="gallery-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                                    </div>
                                </div>
                    @elseif ($index == 3)
                            </div> <!-- Close inner row -->
                        </div>
                        <div class="col-lg-6">
                            <div class="gallery-item large-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
    <!-- Gallery Section End -->
</div>
