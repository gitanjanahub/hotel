<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bookings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.booking-create') }}" class="btn btn-success rounded-pill"><i class="fas fa-edit"></i> Create New</a>
                        </ol>
                    </div>
                </div>
            </div>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" wire:poll.3s>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" wire:poll.3s>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('error') }}
                </div>
            @endif
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-info">Total Bookings: <strong>{{ $totalBookingsCount }}</strong></h4>
                                <!-- Search Input Aligned to the Right -->
                                <div class="ml-auto">
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-100" style="width: 300px;" placeholder="Search Bookings...">
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-2">


                                    <button class="btn btn-danger btn-sm" wire:click="confirmMultipleDelete" {{ count($selectedBookings) === 0 ? 'disabled' : '' }}>
                                        Delete Selected
                                    </button>

                                    @if($bookings->isNotEmpty())
                                        <div class="d-flex justify-content-end mb-2">
                                            <div class="btn-group">
                                                <button wire:click="export('xlsx')" class="btn btn-success btn-sm">Export Excel</button>
                                                <button wire:click="export('xls')" class="btn btn-primary btn-sm">Export XLS</button>
                                                <button wire:click="export('csv')" class="btn btn-info btn-sm">Export CSV</button>
                                                <button wire:click="export('pdf')" class="btn btn-danger btn-sm">Export PDF</button>
                                            </div>
                                        </div>
                                    @endif



                                </div>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" wire:model.live="selectAll"> <!-- Select All Checkbox -->
                                        </th>
                                        <th>Sl No</th>
                                        <th>Customer Name</th>
                                        {{-- <th>Email</th> --}}
                                        <th>Phone</th>
                                        <th>Room</th>
                                        <th>No.Rooms</th>
                                        <th>Tot.Price</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookings as $key => $booking)

                                            <tr wire:key="{{ $booking->id }}">
                                                <td><input type="checkbox" wire:model.live="selectedBookings" value="{{ $booking->id }}"></td>
                                                <td>{{ $bookings->firstItem() + $key }}</td>
                                                <td>{{ $booking->customer_name }}</td>
                                                {{-- <td>{{ $booking->customer_email }}</td> --}}
                                                <td>{{ $booking->customer_phone }}</td>
                                                <td>{{ $booking->room->name ?? 'N/A' }}</td> <!-- Display room name -->
                                                <td>{{ $booking->no_of_rooms }}</td>
                                                <td>{{ number_format($booking->total_price, 2) }} {{ $booking->currency ?? 'INR' }}</td>
                                                <td>{{ $booking->payment_status }}</td>

                                                <td>
                                                    @php
                                                        $checkOutPassed = \Carbon\Carbon::parse($booking->check_out_datetime)->isPast();
                                                        $statusClasses = [
                                                            'Pending' => 'bg-warning text-dark',
                                                            'Confirmed' => 'bg-success text-white',
                                                            'Cancelled' => 'bg-danger text-white'
                                                        ];
                                                    @endphp

                                                    @if ($checkOutPassed)
                                                        <!-- Display status as a uniform badge when check-out time has passed -->
                                                        <span class="badge {{ $statusClasses[$booking->status] }} px-3 py-2 font-weight-bold text-center d-block" style="font-size: 14px; width: 120px;">
                                                            {{ $booking->status }}
                                                        </span>
                                                    @else
                                                        <!-- Show dropdown when check-out time has not passed -->
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle px-3 py-2 font-weight-bold text-center d-block"
                                                                style="width: 120px; font-size: 14px;"
                                                                type="button" id="dropdownMenuButton{{ $booking->id }}"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                                :class="'{{ $statusClasses[$booking->status] }}'">
                                                                {{ $booking->status }}
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                                                                <a class="dropdown-item" wire:click="updateStatus({{ $booking->id }}, 'Pending')">Pending</a>
                                                                <a class="dropdown-item" wire:click="updateStatus({{ $booking->id }}, 'Confirmed')">Confirmed</a>
                                                                <a class="dropdown-item" wire:click="updateStatus({{ $booking->id }}, 'Cancelled')">Cancelled</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($booking->check_in_datetime)->format('d M Y') }} <br>
                                                    <small>
                                                        {{ \Carbon\Carbon::parse($booking->check_in_datetime)->format('g' .
                                                            (\Carbon\Carbon::parse($booking->check_in_datetime)->format('i') != '00' ? ':i' : '') . ' A') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($booking->check_out_datetime)->format('d M Y') }} <br>
                                                    <small>
                                                        {{ \Carbon\Carbon::parse($booking->check_out_datetime)->format('g' .
                                                            (\Carbon\Carbon::parse($booking->check_out_datetime)->format('i') != '00' ? ':i' : '') . ' A') }}
                                                    </small>
                                                </td>



                                                {{-- <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="switch-{{ $booking->id }}"
                                                            wire:model="bookings.{{ $loop->index }}.is_active"
                                                            wire:change="toggleActive({{ $booking->id }}, $event.target.checked)"
                                                            {{ $booking->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="switch-{{ $booking->id }}"></label>
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $booking->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i> <!-- Three dots icon -->
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                                                            <a wire:navigate href="{{ route('admin.booking-view', $booking->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>

                                                            @if (!$checkOutPassed && $booking->check_in_status !== 'Checked Out')
                                                                <a wire:navigate href="{{ route('admin.booking-edit', $booking->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if ($booking->check_in_status === 'Not Checked In')
                                                                <button wire:click="updateCheckIn({{ $booking->id }})" class="dropdown-item text-primary">
                                                                    <i class="fas fa-sign-in-alt"></i> Mark as Checked In
                                                                </button>
                                                            @endif

                                                            @if ($booking->check_in_status === 'Checked In')
                                                                <button wire:click="updateCheckOut({{ $booking->id }})" class="dropdown-item text-success">
                                                                    <i class="fas fa-sign-out-alt"></i> Mark as Checked Out
                                                                </button>
                                                            @endif

                                                            <button wire:click="confirmDelete({{ $booking->id }})" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12" >
                                                    <div class="alert alert-warning alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                                        No Items In Bookings.
                                                      </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $bookings->links() }}
                                </div>

                                <div class="border p-2 rounded">
                                    <strong class="text-primary">Import Bookings via CSV</strong>

                                    <input type="file" wire:model="importFile" class="form-control-file my-1" accept=".csv">

                                    <!-- Import Button -->
                                    <button class="btn btn-secondary btn-sm" wire:click="importBookings" wire:loading.attr="disabled">
                                        Import CSV
                                    </button>

                                    <!-- Loading text -->
                                    <div wire:loading wire:target="importBookings" class="text-warning mt-1">
                                        Importing...
                                    </div>

                                    <!-- Sample File Link -->
                                    <a href="{{ asset('samples/booking-import-sample.csv') }}" class="btn btn-link btn-sm" download>
                                        Download Sample File
                                    </a>

                                    <small class="text-muted">Upload a .csv file in the required format. Max 2MB.</small>
                                    @error('importFile') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                {{-- @if (session()->has('success'))
                                    <div class="alert alert-success mt-2">
                                        {{ session('success') }}
                                    </div>
                                @endif --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




<div>
    <!-- Delete Confirmation Modal (Single) -->
    @if($showDeleteModal)
    <div class="modal fade show" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" wire:click="$set('showDeleteModal', false)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this booking?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteBooking" wire:click="$set('showDeleteModal', false)">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Multiple Delete Confirmation Modal -->
    @if($showMultipleDeleteModal)
    <div class="modal fade show" id="multipleDeleteModal" tabindex="-1" aria-labelledby="multipleDeleteModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multipleDeleteModalLabel">Confirm Multiple Deletions</h5>
                    <button type="button" class="close" wire:click="$set('showMultipleDeleteModal', false)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected bookings?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showMultipleDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteSelectedBookings" wire:click="$set('showMultipleDeleteModal', false)">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>





