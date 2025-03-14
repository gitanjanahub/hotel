<div class="content-wrapper" style="margin-left: 5%;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark">Booking Details</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a wire:navigate href="{{ route('admin.bookings') }}" class="btn btn-primary rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title font-weight-bold">Booking Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="h5 text-secondary">Customer Details</p>
                                    <hr>
                                    <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
                                    <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
                                    <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="h5 text-secondary">Room Details</p>
                                    <hr>
                                    <p><strong>Room:</strong> {{ $booking->room->name }}</p>
                                    <p><strong>Number of Rooms:</strong> {{ $booking->no_of_rooms }}</p>
                                    <p><strong>Price per Room:</strong> {{ number_format($booking->price, 2) }} {{ $booking->currency ?? 'INR' }}</p>
                                    <p><strong>Total Price:</strong> <span class="text-success font-weight-bold">{{ number_format($booking->total_price, 2) }} {{ $booking->currency ?? 'INR' }}</span></p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <p class="h5 text-secondary">Check-in & Check-out</p>
                                    <hr>
                                    <p><strong>Check-in:</strong> {{ $booking->check_in_datetime }}</p>
                                    <p><strong>Check-out:</strong> {{ $booking->check_out_datetime }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="h5 text-secondary">Booking Status</p>
                                    <hr>
                                    <p><strong>Status:</strong>
                                        <span class="badge
                                            {{ $booking->status == 'Pending' ? 'bg-warning text-dark' :
                                            ($booking->status == 'Confirmed' ? 'bg-success text-white' : 'bg-danger text-white') }}">
                                            {{ $booking->status }}
                                        </span>
                                    </p>
                                    <p><strong>Check-in Status:</strong> {{ $booking->check_in_status }}</p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <p class="h5 text-secondary">Payment Details</p>
                                    <hr>
                                    <p><strong>Payment Type:</strong> {{ ucfirst(str_replace('_', ' ', $booking->payment_type)) }}</p>
                                    <p><strong>Payment Status:</strong>
                                        <span class="badge {{ $booking->payment_status == 'Paid' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                            {{ $booking->payment_status }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a wire:navigate href="{{ route('admin.bookings') }}" class="btn btn-secondary rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
