<div class="content-wrapper" style="margin-left: 5% !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark">Create Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a wire:navigate href="{{ route('admin.bookings') }}" class="btn btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-arrow-left"></i> Back to Bookings
                        </a>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Booking Details</h3>
                        </div>

                        <form wire:submit.prevent="save">
                            <div class="card-body">




                                <p class="h5 font-weight-bold text-primary">Customer Details</p>
                                <hr class="border border-primary border-2 mb-4">

                                <!-- Customer Details -->
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <!-- Customer Name -->
                                        <div class="form-group">
                                            <label for="customerName">Name</label>
                                            <input type="text" wire:model="customer_name" class="form-control" id="customerName" placeholder="Enter customer name">
                                            @error('customer_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <!-- Customer Email -->
                                        <div class="form-group">
                                            <label for="customerEmail">Email</label>
                                            <input type="email" wire:model="customer_email" class="form-control" id="customerEmail" placeholder="Enter customer email">
                                            @error('customer_email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <!-- Customer Phone -->
                                        <div class="form-group">
                                            <label for="customerPhone">Phone</label>
                                            <input type="text" wire:model="customer_phone" class="form-control" id="customerPhone" placeholder="Enter customer phone">
                                            @error('customer_phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <p class="h5 font-weight-bold text-primary">Room Details</p>
                                <hr class="border border-primary border-2 mb-4">

                                <div class="row">


                                    <!-- Left Column -->
                                    <div class="col-md-6 mb-3">
                                        <!-- Room Selection -->
                                        <div class="form-group">
                                            <label for="room">Room</label>
                                            <select wire:model.live="room_id" class="form-control" id="room">
                                                <option value="">Select Room</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->name }} ( Available Rooms : {{ $room->available_rooms }})</option>
                                                @endforeach
                                            </select>

                                            @error('room_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Number of Rooms -->
                                        <div class="form-group">
                                            <label for="noOfRooms">Number of Rooms</label>
                                            <input type="number" wire:model.live="no_of_rooms" class="form-control" id="noOfRooms" placeholder="Enter number of rooms" min="1">


                                            @error('no_of_rooms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Adults -->
                                        <div class="form-group">
                                            <label for="adults">Number of Adults</label>
                                            <input type="number" wire:model.live="adults" class="form-control" id="adults" placeholder="Enter number of adults" min="1">
                                            @error('adults')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6 mb-3">
                                        <!-- Price -->
                                        <div class="form-group">
                                            <label for="Price">Price</label>
                                            <input type="number" wire:model="price" class="form-control" id="Price" readonly placeholder="Price">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Total Price -->
                                        <div class="form-group">
                                            <label for="totalPrice">Total Price</label>
                                            <input type="text" readonly wire:model="total_price" class="form-control" id="totalPrice" placeholder="Total price">
                                            @error('total_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Children -->
                                        <div class="form-group">
                                            <label for="children">Number of Children</label>
                                            <input type="number" wire:model.live="children" class="form-control" id="childrens" placeholder="Enter number of children" min="0">
                                            @error('children')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <p class="h5 font-weight-bold text-primary">Check-in & Check-out Details</p>
                                <hr class="border border-primary border-2 mb-4">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <!-- Check-in DateTime -->
                                        <div class="form-group">
                                            <label for="checkIn">Check-in Date & Time</label>
                                            <input type="datetime-local" wire:model.live="check_in_datetime" class="form-control" id="checkIn">
                                            @error('check_in_datetime')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <!-- Check-out DateTime -->
                                        <div class="form-group">
                                            <label for="checkOut">Check-out Date & Time</label>
                                            <input type="datetime-local" wire:model.live="check_out_datetime" class="form-control" id="checkOut">
                                            @error('check_out_datetime')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <p class="h5 font-weight-bold text-primary">Other Details</p>
                                <hr class="border border-primary border-2 mb-4">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <!-- Booking Status -->
                                        <div class="form-group">
                                            <label for="status">Booking Status</label>
                                            <select wire:model="status" class="form-control" id="status">
                                                <option value="Pending">Pending</option>
                                                <option value="Confirmed">Confirmed</option>
                                                {{-- <option value="Cancelled">Cancelled</option> --}}
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <!-- Check-in Status -->
                                        <div class="form-group">
                                            <label for="checkInStatus">Check-in Status</label>
                                            <select wire:model="check_in_status" class="form-control" id="checkInStatus">
                                                <option value="Not Checked In">Not Checked In</option>
                                                <option value="Checked In">Checked In</option>
                                                {{-- <option value="Checked Out">Checked Out</option> --}}
                                            </select>
                                            @error('check_in_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <!-- Payment Type -->
                                        <div class="form-group">
                                            <label for="payment_type">Payment Type</label>
                                            <select wire:model="payment_type" class="form-control" id="payment_type">
                                                <option value="">Select</option>
                                                <option value="cod">Cash</option>
                                                <option value="online">Online Payment</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                            </select>
                                            @error('payment_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <!-- Payment Status -->
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                            <select wire:model="payment_status" class="form-control" id="payment_status">
                                                <option value="Pending">Pending</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                            @error('payment_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm" wire:loading.attr="disabled"
                                wire:target="save"
                                @disabled($errors->isNotEmpty())>
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
