<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Rooms</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a wire:navigate href="{{ route('admin.room-types') }} " class="btn btn-primary rounded-pill"><i class="fas fa-arrow-left"></i> Back to Rooms</a>

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
                    <h3 class="card-title">Create Rooms</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-6">
                                <!-- Room Name -->
                                <div class="form-group">
                                    <label for="name">Room Name</label>
                                    <input type="text" id="name" class="form-control" wire:model="name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <!-- Price Per Night -->
                                <div class="form-group">
                                    <label for="price_per_night">Price Per Night</label>
                                    <input type="number" id="price_per_night" class="form-control" wire:model="price_per_night">
                                    @error('price_per_night') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Bed Type -->
                                <div class="form-group">
                                    <label for="bed">Bed Type</label>
                                    <input type="text" id="bed" class="form-control" wire:model="bed">
                                    @error('bed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>





                                <!-- Adults -->
                                <div class="form-group">
                                    <label for="adults">Adults</label>
                                    <input type="number" id="adults" class="form-control" wire:model="adults">
                                    @error('adults') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Available Rooms -->
                                <div class="form-group">
                                    <label for="available_rooms">Available Rooms</label>
                                    <input type="number" id="available_rooms" class="form-control" wire:model="available_rooms">
                                    @error('available_rooms') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Room Services -->
                                <div class="form-group">
                                    <label>Services</label>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($services as $service)
                                            <div class="form-check mr-3">
                                                <input type="checkbox" id="service_{{ $service->id }}" class="form-check-input"
                                                    wire:model="selected_services" value="{{ $service->id }}">
                                                <label for="service_{{ $service->id }}" class="form-check-label">
                                                    {{ $service->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('selected_services') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="isActive">Is Active</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" wire:model="is_active" class="custom-control-input" id="isActive">
                                        <label class="custom-control-label" for="isActive"></label>
                                    </div>
                                </div>

                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-6">

                                <!-- Room Type -->
                                <div class="form-group">
                                    <label for="room_type_id">Room Type</label>
                                    <select id="room_type_id" class="form-control" wire:model="room_type_id">
                                        <option value="">Select Room Type</option>
                                        @foreach ($roomtypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Room Size -->
                                <div class="form-group">
                                    <label for="size">Room Size (in sq. ft)</label>
                                    <input type="number" id="size" class="form-control" wire:model="size">
                                    @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Capacity -->
                                <div class="form-group">
                                    <label for="capacity">Room Capacity</label>
                                    <input type="number" id="capacity" class="form-control" wire:model="capacity" min="1">
                                    @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Children -->
                                <div class="form-group">
                                    <label for="children">Children</label>
                                    <input type="number" id="childrens" class="form-control" wire:model="children">
                                    @error('children') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>







                                <!-- Thumbnail Image -->
                                <div class="form-group">
                                    <label for="image">Thumbnail Image</label>
                                    <input type="file" id="image" class="form-control-file" wire:model="image">
                                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Additional Images -->
                                <div class="form-group">
                                    <label for="images">Additional Images</label>
                                    <input type="file" id="images" class="form-control-file" wire:model="images" multiple>
                                    @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-success">Create Room</button>
                        </div>
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

