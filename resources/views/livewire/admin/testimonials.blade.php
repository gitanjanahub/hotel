<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Testimonials</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.testimonial-create') }}" class="btn btn-success rounded-pill"><i class="fas fa-edit"></i> Create New</a>
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
                                <h4 class="card-title text-info">Total Testimonials: <strong>{{ $totalTestimonialsCount }}</strong></h4>
                                <!-- Search Input Aligned to the Right -->
                                <div class="ml-auto">
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-100" style="width: 300px;" placeholder="Search Testimonial...">
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-2">
                                    {{-- <button class="btn btn-danger btn-sm" wire:click="confirmMultipleDelete" {{ count($selectedservices) ? '' : 'disabled' }}>
                                        Delete Selected
                                    </button> --}}

                                    <button class="btn btn-danger btn-sm" wire:click="confirmMultipleDelete" {{ count($selectedTestimonials) === 0 ? 'disabled' : '' }}>
                                        Delete Selected
                                    </button>

                                </div>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" wire:model.live="selectAll"> <!-- Select All Checkbox -->
                                        </th>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Content</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($testimonials as $key => $testm)
                                            <tr wire:key="{{ $testm->id }}">
                                                <td><input type="checkbox" wire:model.live="selectedTestimonials" value="{{ $testm->id }}"></td>
                                                <td>{{ $testimonials->firstItem() + $key }}</td>
                                                <td>{{ $testm->name }}</td>

                                                <td>{{ $testm->content }}</td> <!-- Display the product count -->

                                                <td>
                                                    <img src="{{ asset('storage/' . $testm->image) }}" alt="{{ $testm->name }}" width="50" height="50">
                                                </td>


                                                <td>
                                                    {{-- <a wire:navigate href="{{ route('admin.testimonial-view', $testm->id) }}" class="btn btn-primary btn-sm rounded-pill" title="View">
                                                        <i class="fas fa-eye"></i> View
                                                    </a> --}}
                                                    <a wire:navigate class="btn btn-warning btn-sm rounded-pill" title="Edit" href="{{ route('admin.testimonial-edit', $testm->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button wire:click="confirmDelete({{ $testm->id }})" class="btn btn-danger btn-sm rounded-pill" title="Delete" data-toggle="modal" data-target="#deleteModal">
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
                                                        No Items In Testimonials.
                                                      </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $testimonials->links() }}
                                </div>
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
                    Are you sure you want to delete this Testimonial?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteTestimonial" wire:click="$set('showDeleteModal', false)">Yes, Delete</button>
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
                    Are you sure you want to delete the selected testimonial?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showMultipleDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteSelectedTestimonials" wire:click="$set('showMultipleDeleteModal', false)">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>





