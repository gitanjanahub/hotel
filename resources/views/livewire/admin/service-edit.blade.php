<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Services</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a wire:navigate href="{{ route('admin.services') }} " class="btn btn-primary rounded-pill"><i class="fas fa-arrow-left"></i> Back to Services</a>

                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Service</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form wire:submit.prevent="save">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="serviceName">Service Name</label>
                            <input type="text" wire:model.lazy="name" class="form-control" id="serviceName" placeholder="Service Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model="description" class="form-control"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="homePage">Display Home Page</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="home_page" class="custom-control-input" id="homePage" @checked($this->home_page)>
                                <label class="custom-control-label" for="homePage"></label>
                            </div>
                        </div>

                        <!-- Image -->
                        {{-- <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" class="form-control-file" wire:model="image">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                            @if ($image)
                                <p>Preview:</p>
                                @if (!is_string($image))
                                    <img src="{{ $image->temporaryUrl() }}" width="100">
                                @else
                                    <img src="{{ asset('storage/' . $image) }}" width="100">
                                @endif
                            @endif

                        </div> --}}


                        <div class="form-group">
                            <label for="isActive">Is Active</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="is_active" class="custom-control-input" id="isActive" @checked($this->is_active)>
                                <label class="custom-control-label" for="isActive"></label>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                </div>
                <!-- /.card -->
                </div>
              <!--/.col (left) -->
              <!-- right column -->
              <div class="col-md-6">

              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
</div>

