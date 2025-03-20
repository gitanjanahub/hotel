<div class="content-wrapper" style="margin-left: 5% !important;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark">Banner</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a wire:navigate href="{{ route('admin.banner') }}" class="btn btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-arrow-left"></i> Back to Banner
                        </a>
                    </ol>
                </div> --}}
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
                            <h3 class="card-title font-weight-bold">Banner Details</h3>
                        </div>

                        <div class="container mt-4">
                            @if (session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <form wire:submit.prevent="save">

                                <div class="form-group">
                                    <label>Title</label>
                                    <textarea wire:model="title" class="form-control"></textarea>
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>



                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea wire:model="description" class="form-control"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                        <label>Images</label>
                                        <input type="file" wire:model="images" class="form-control" accept="image/*" multiple>
                                        @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror

                                        {{-- @if($images)
                                            <div class="mt-3">
                                                @foreach($images as $image)
                                                    <img src="{{ $image->temporaryUrl() }}" width="100" class="m-2">
                                                @endforeach
                                            </div>
                                        @endif --}}

                                        @if(isset($banner->images))
                                        @foreach(json_decode($banner->images) as $image)
                                            <div class="d-inline-block position-relative m-2">
                                                <img src="{{ asset('storage/' . $image) }}" width="100">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top:0; right:0;" wire:click="deleteImage('{{ $image }}')">
                                                    &times;
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif


                                    </div>




                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
