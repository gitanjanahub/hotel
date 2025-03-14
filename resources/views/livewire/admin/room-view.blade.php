<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Room Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.rooms') }}" class="btn btn-primary rounded-pill mr-2">
                                <i class="fas fa-arrow-left"></i> Back to Rooms
                            </a>
                            <a wire:navigate href="{{ route('admin.room-create') }}" class="btn btn-success rounded-pill">
                                <i class="fas fa-edit"></i> Create New
                            </a>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- Room details card -->
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow-lg">
                            <div class="card-header bg-info text-white">
                                <h3 class="card-title">Room Information</h3>
                            </div>
                            <div class="card-body">
                                <!-- Room Details -->
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%;">Room Name:</th>
                                            <td>{{ $room->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Room Type:</th>
                                            <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price per Night:</th>
                                            <td>${{ $room->price_per_night }}</td>
                                        </tr>
                                        <tr>
                                            <th>Capacity:</th>
                                            <td>{{ $room->capacity }} people</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                @if($room->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Room Services -->
                                <h5 class="mt-4">Services</h5>
                                <ul class="list-group">
                                    @forelse ($room->roomServices as $service)
                                        <li class="list-group-item">{{ $service->name }}</li>
                                    @empty
                                        <li class="list-group-item text-muted">No services assigned to this room.</li>
                                    @endforelse
                                </ul>

                                <!-- Room Images -->
                                <h5 class="mt-4">Images</h5>
                                <div class="d-flex flex-wrap">
                                    @if ($room->image)
                                        <div class="p-2">
                                            <img src="{{ asset('storage/' . $room->image) }}" alt="Room Thumbnail" style="max-width: 150px;" class="rounded shadow-sm">
                                        </div>
                                    @endif

                                    @if ($room->images)
                                        @foreach (json_decode($room->images) as $image)
                                            <div class="p-2">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Room Image" style="max-width: 150px;" class="rounded shadow-sm">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer with Action Buttons -->
                            <div class="card-footer d-flex justify-content-between">
                                <a wire:navigate href="{{ route('admin.room-edit', $room->id) }}" class="btn btn-warning rounded-pill">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a wire:click="confirmDelete({{ $room->id }})" class="btn btn-danger rounded-pill" title="Delete" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a wire:navigate href="{{ route('admin.rooms') }}" class="btn btn-secondary rounded-pill">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this room?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteRoom" data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
