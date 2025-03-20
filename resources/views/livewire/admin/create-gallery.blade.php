<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Gallery</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a wire:navigate href="{{ route('admin.galleries') }}" class="btn btn-primary rounded-pill">
                        <i class="fas fa-arrow-left"></i> Back to Gallery
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
                    <h3 class="card-title">Create Gallery</h3>
                  </div>

                  <!-- Form Start -->
                  <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="images">Upload Images</label>
                            <input type="file" id="images" class="form-control-file" wire:model="images" multiple>
                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Show uploaded image previews -->
                        <div class="row mt-3">
                            @foreach($images as $image)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" width="100">
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-success">Create Gallery</button>
                        </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
</div>
