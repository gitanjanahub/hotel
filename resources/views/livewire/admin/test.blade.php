<div class="content-wrapper" style="margin-left: 5% !important;">


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


                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
