<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Services</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.service-create') }}" class="btn btn-success rounded-pill"><i class="fas fa-edit"></i> Create New</a>
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
                                <h4 class="card-title text-info">Total services: <strong>{{ $totalServicesCount }}</strong></h4>
                                <!-- Search Input Aligned to the Right -->
                                <div class="ml-auto">
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-100" style="width: 300px;" placeholder="Search services...">
                                </div>
                            </div>
                            <div class="card-body">


                                <div class="mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                        <!-- Delete Selected Button -->
                                        <div>
                                            <button class="btn btn-danger btn-sm" wire:click="confirmMultipleDelete" {{ count($selectedServices) === 0 ? 'disabled' : '' }}>
                                                Delete Selected
                                            </button>
                                        </div>


                                        <!-- Export Buttons (Only shown if there is data) -->
                                        @if($services->isNotEmpty())
                                            <div class="btn-group">
                                                <button wire:click="export('xlsx')" class="btn btn-success btn-sm">Export Excel</button>
                                                <button wire:click="export('xls')" class="btn btn-primary btn-sm">Export XLS</button>
                                                <button wire:click="export('csv')" class="btn btn-info btn-sm">Export CSV</button>
                                                <button wire:click="export('pdf')" class="btn btn-danger btn-sm">Export PDF</button>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" wire:model.live="selectAll"> <!-- Select All Checkbox -->
                                        </th>
                                        <th>Sl No</th>
                                        <th>Service Name</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Rooms</th>
                                        <th>Home Page Display</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($services as $key => $service)
                                            <tr wire:key="{{ $service->id }}">
                                                <td><input type="checkbox" wire:model.live="selectedServices" value="{{ $service->id }}"></td>
                                                <td>{{ $services->firstItem() + $key }}</td>
                                                <td>{{ $service->name }}</td>
                                                {{-- <td>
                                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" width="50" height="50">
                                                </td> --}}
                                                <td>{{ $service->rooms_count }}</td> <!-- Display the product count -->


                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="hmswitch-{{ $service->id }}"
                                                            wire:model="services.{{ $loop->index }}.home_page"
                                                            wire:change="homeToggleActive({{ $service->id }}, $event.target.checked)"
                                                            {{ $service->home_page ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="hmswitch-{{ $service->id }}"></label>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="switch-{{ $service->id }}"
                                                            wire:model="services.{{ $loop->index }}.is_active"
                                                            wire:change="toggleActive({{ $service->id }}, $event.target.checked)"
                                                            {{ $service->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="switch-{{ $service->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a wire:navigate href="{{ route('admin.service-view', $service->id) }}" class="btn btn-primary btn-sm rounded-pill" title="View">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a wire:navigate class="btn btn-warning btn-sm rounded-pill" title="Edit" href="{{ route('admin.service-edit', $service->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button wire:click="confirmDelete({{ $service->id }})" class="btn btn-danger btn-sm rounded-pill" title="Delete" data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" >
                                                    <div class="alert alert-warning alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                                        No Items In Services.
                                                      </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $services->links() }}
                                </div>

                                <div class="d-flex flex-column gap-2 mt-4">
                                    <!-- Informational Sentence -->
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Before importing, please upload images first.
                                    </div>

                                    <!-- CSV Upload Section -->
                                    <div class="border p-2 rounded">
                                        <strong class="text-primary">Import Services via CSV</strong>

                                        <input type="file" wire:model="importFile" class="form-control-file my-1" accept=".csv">

                                        <!-- Import Button (disabled while loading) -->
                                        <button class="btn btn-secondary btn-sm" wire:click="importServices" wire:loading.attr="disabled">
                                            Import CSV
                                        </button>

                                        <!-- Show loading while import is in progress -->
                                        <div wire:loading wire:target="importServices" class="text-warning mt-1">
                                            Importing...
                                        </div>

                                        <a href="{{ asset('samples/service-import-sample.csv') }}" class="btn btn-link btn-sm" download>
                                            Download Sample File
                                        </a>

                                        <small class="text-muted">Upload a .csv file in the required format. Max 2MB.</small>
                                        @error('importFile') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="border p-2 rounded mt-3">
                                        <strong class="text-primary">Upload Service Images</strong>

                                        <input type="file" wire:model="images" class="form-control-file my-1" multiple accept="image/*">

                                        <!-- Show loading while images are uploading -->
                                        <div wire:loading wire:target="images" class="text-warning mt-1">
                                            Uploading images...
                                        </div>

                                        <small class="text-muted">You can upload multiple service images here. JPEG, PNG only.</small>
                                        @error('images') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- Delete Confirmation Modal (Single) -->
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
                    Are you sure you want to delete this service?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteService" wire:click="$set('showDeleteModal', false)">Yes, Delete</button>
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
                    Are you sure you want to delete the selected services?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showMultipleDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteSelectedServices" wire:click="$set('showMultipleDeleteModal', false)">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>



