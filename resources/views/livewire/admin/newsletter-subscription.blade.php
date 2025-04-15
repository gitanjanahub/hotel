<div class="content-wrapper" style="margin-left: 5% !important;">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Newsletter Subscribers</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="text-info">Total Subscribers: <strong>{{ $totalSubscribers }}</strong></h4>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-100" style="width: 300px;" placeholder="Search Emails...">
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <button class="btn btn-danger btn-sm" wire:click="confirmMultipleDelete" {{ count($selectedSubscribers) === 0 ? 'disabled' : '' }}>
                            Delete Selected
                        </button>
                        @if($newsletters->isNotEmpty())
                            <div class="d-flex justify-content-end mb-2">
                                <div class="btn-group">
                                <button class="btn btn-success btn-sm" wire:click="export('xlsx')">Export Excel</button>
                                <button class="btn btn-info btn-sm" wire:click="export('csv')">Export CSV</button>
                                <button class="btn btn-primary btn-sm" wire:click="export('xls')">Export XLS</button>
                                <button class="btn btn-danger btn-sm" wire:click="export('pdf')">Export PDF</button>
                                </div>
                            </div>
                        @endif
                    </div>




                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                            <th>Sl No</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($newsletters as $key => $subscriber)
                            <tr wire:key="{{ $subscriber->id }}">
                                <td><input type="checkbox" wire:model.live="selectedSubscribers" value="{{ $subscriber->id }}"></td>
                                <td>{{ $newsletters->firstItem() + $key }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>
                                    <button wire:click="confirmDelete({{ $subscriber->id }})" class="btn btn-danger btn-sm rounded-pill">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-warning">No subscribers found.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $newsletters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    Are you sure you want to delete this subscriber?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteSubscriber" wire:click="$set('showDeleteModal', false)">Yes, Delete</button>
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
                    Are you sure you want to delete the selected subscribers?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showMultipleDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteSelectedSubscribers" wire:click="$set('showMultipleDeleteModal', false)">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
