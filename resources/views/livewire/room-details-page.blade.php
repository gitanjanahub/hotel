<div>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Our Rooms</h2>
                        <div class="bt-option">
                            <a href="/">Home</a>
                            <span>Rooms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Room Details Section Begin -->
    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="room-details-item">
                        {{-- <img src="img/room/room-details.jpg" alt=""> --}}

                        {{-- <div id="roomCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($room->images ?? [] as $key => $image)

                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded-lg shadow-md" alt="{{ $room->name }}">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="carousel-control-prev" href="#roomCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#roomCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div> --}}

                        <div id="roomCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @if(!empty($room->images) && is_array($room->images))
                                    @foreach ($room->images as $key => $image)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded-lg shadow-md" alt="{{ $room->name }}">
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Fallback for no images -->
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/default-room.jpg') }}" class="d-block w-100 rounded-lg shadow-md" alt="Default Room Image">
                                    </div>
                                @endif
                            </div>

                            <!-- Controls -->
                            <a class="carousel-control-prev" href="#roomCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#roomCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>



                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>
                                    {{ $room->name }}
                                    @if ($room->available_rooms == 0)
                                        <span class="room-status red">(Sold Out)</span>
                                    @elseif ($room->available_rooms == 1)
                                        <span class="room-status orange">(1 Room)</span>
                                    @else
                                        <span class="room-status green">({{ $room->available_rooms }} Rooms)</span>
                                    @endif
                                </h3>



                                <div class="rdt-right">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                    {{-- <a wire:click="goToCheckout" class="bk-btn hover-thumb" style="cursor: pointer;">
                                        Booking Now

                                    </a> --}}

                                    @if(auth()->check())
                                        <a type="button" wire:click="goToCheckout" class="bk-btn hover-thumb">Checkout</a>
                                    @else

                                    @php
                                        session(['url.intended' => route('checkout')]);
                                    @endphp

                                        <a type="button" class="bk-btn hover-thumb" data-toggle="modal" data-target="#loginModal">
                                            Checkout
                                          </a>

                                          {{-- <livewire:modals.login-signup/> --}}
                                          {{-- <livewire:auth.login-page/> --}}
                                    @endif


                                    {{-- <a wire:click="goToCheckout" class="bk-btn">Booking Now</a> --}}
                                </div>
                            </div>
                            <h2>{{  Number::currency($room->price_per_night , 'INR') }}<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>{{ $room->size }} sqm</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>{{ $room->capacity }}</td>
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
                            <div class="f-para">{!! $room->description !!}</div>


                        </div>
                    </div>
                    <div class="rd-reviews">
                        <h4>Reviews</h4>
                        <div class="review-item">
                            <div class="ri-pic">
                                {{-- <img src="img/room/avatar/avatar-1.jpg" alt=""> --}}
                            </div>
                            <div class="ri-text">
                                <span>27 Aug 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Brandon Kelley</h5>
                                <p>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                    adipisci velit, sed quia non numquam eius modi tempora. incidunt ut labore et dolore
                                    magnam.</p>
                            </div>
                        </div>
                        <div class="review-item">
                            <div class="ri-pic">
                                {{-- <img src="img/room/avatar/avatar-2.jpg" alt=""> --}}
                            </div>
                            <div class="ri-text">
                                <span>27 Aug 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Brandon Kelley</h5>
                                <p>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                    adipisci velit, sed quia non numquam eius modi tempora. incidunt ut labore et dolore
                                    magnam.</p>
                            </div>
                        </div>
                    </div>
                    <div class="review-add">
                        <h4>Add Review</h4>
                        <form action="#" class="ra-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name*">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email*">
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <h5>You Rating:</h5>
                                        <div class="rating">
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star-half_alt"></i>
                                        </div>
                                    </div>
                                    <textarea placeholder="Your Review"></textarea>
                                    <button type="submit">Submit Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    <div class="room-booking">
                        <h3>Your Reservation</h3>
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
                                    <option value="">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="room">Room:</label>
                                <select id="room">
                                    <option value="">1 Room</option>
                                </select>
                            </div>
                            <button type="submit">Check Availability</button>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->
</div>

@push('styles')

<style>
    .room-status {
        font-weight: 500;
        margin-left: 8px;
    }

    .room-status.red {
        color: red;
        font-family: 'Courier New', monospace;
    }

    .room-status.orange {
        color: orange;
        font-family: 'Georgia', serif;
    }

    .room-status.green {
        color: green;
        font-family: 'Arial Black', sans-serif;
    }
</style>


@endpush

{{-- @push('scripts')
    <script>
        // Listen for the event dispatched by Livewire
        Livewire.on('redirectToCheckout', () => {
            // Redirect to checkout page without reload
            window.location.href = '/checkout';
        });
    </script>
@endpush --}}


