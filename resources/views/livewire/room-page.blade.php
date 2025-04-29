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

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">

                @if($rooms)
                    @foreach($rooms as $room)
                        <div class="col-lg-4 col-md-6">
                            <div class="room-item">
                                <img src="{{ asset('storage/' . $room->image) }}" alt="">
                                <div class="ri-text">
                                    <h4>{{ $room->name }}</h4>
                                    <h3>{{  Number::currency($room->price_per_night , 'INR') }}<span>/Pernight</span></h3>
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
                                            {{-- <tr>
                                                <td class="r-o">Services:</td>
                                                <td>
                                                    {{ $room->roomServices->pluck('name')->join(', ') }}
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td class="r-o">Services:</td>
                                                <td>
                                                    @php
                                                        $services = $room->roomServices->pluck('name');
                                                        $displayServices = $services->take(2)->join(', ');
                                                    @endphp

                                                    {{ $displayServices }}
                                                    @if($services->count() > 2)
                                                        etc.
                                                    @endif
                                                </td>
                                            </tr>

                                            @endif
                                            <tr>
                                                <td class="r-o">Available:</td>
                                                <td>
                                                    @if($room->available_rooms == 0)
                                                        <span class="text-danger fw-bold">Sold Out</span>
                                                    @elseif($room->available_rooms < 5)
                                                        <span class="text-danger fw-semibold">{{ $room->available_rooms }} Room{{ $room->available_rooms > 1 ? 's' : '' }} Left</span>
                                                    @else
                                                        {{ $room->available_rooms }} Rooms
                                                    @endif
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <a href="/rooms/{{ $room->slug }}" class="primary-btn">More Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="col-lg-12">
                        <div class="room-pagination">
                            @if ($rooms->lastPage() > 1)
                                @if (!$rooms->onFirstPage())
                                    <a href="#" wire:click.prevent="previousPage">Prev</a>
                                @endif

                                @for ($page = 1; $page <= $rooms->lastPage(); $page++)
                                    @if ($page == $rooms->currentPage())
                                        <a href="#" class="active">{{ $page }}</a>
                                    @else
                                        <a href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                    @endif
                                @endfor

                                @if ($rooms->hasMorePages())
                                    <a href="#" wire:click.prevent="nextPage">Next <i class="fa fa-long-arrow-right"></i></a>
                                @endif
                            @endif
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->
</div>
