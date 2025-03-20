<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gallery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.gallery-create') }}" class="btn btn-success rounded-pill">
                                <i class="fas fa-edit"></i> Create New
                            </a>
                        </ol>
                    </div>
                </div>
            </div>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @forelse($galleries as $gallery)
                        <div class="col-sm-2 mb-3">
                            <a href="{{ asset('storage/' . $gallery->image) }}" data-toggle="lightbox" data-title="Gallery Image" data-gallery="gallery">
                                <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid mb-2" alt="Gallery Image">
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <h4>No images found.</h4>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $galleries->links() }}
                </div>
            </div>
        </section>
    </div>
</div>
