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
                    <a wire:navigate href="{{ route('admin.rooms') }} " class="btn btn-primary rounded-pill"><i class="fas fa-arrow-left"></i> Back to Rooms</a>

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

                                <div class="form-group" wire:ignore>
                                    <label for="description">Room Description</label>
                                    <textarea id="summernote" class="form-control" wire:model.defer="description" wire:ignore></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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

                                <!-- Home Page Thumbnail Image -->
                                <div class="form-group">
                                    <label for="home_thumb">Home Page Thumbnail Image</label>
                                    <input type="file" id="home_thumb" class="form-control-file" wire:model="home_thumb">
                                    @error('home_thumb') <span class="text-danger">{{ $message }}</span> @enderror
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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            function initSummernote() {
                $('#summernote').summernote({
                    height: 200,
                    callbacks: {
                        onChange: function (contents) {
                            Livewire.emit('updateDescription', contents); // Emit to Livewire
                        }
                    }
                });

                // Set initial value from Livewire
                Livewire.on('setDescription', (value) => {
                    $('#summernote').summernote('code', value);
                });
            }

            initSummernote(); // Initialize on first load

            Livewire.hook('message.processed', (message, component) => {
                if (!$('#summernote').hasClass('note-editor')) {
                    initSummernote(); // Reinitialize only if not already initialized
                }
            });
        });
    </script> --}}

     <!-- Load jQuery and Summernote -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize Summernote editor with full configuration and proper callback
    $('#summernote').summernote({
        placeholder: 'Type something cool', // Placeholder text in the editor
        tabsize: 2, // Tab size for indenting
        height: 500, // Height of the editor
        focus: true, // Set focus to the editor on load
        lang: 'en-US', // Language for the editor
        maxHeight: 600, // Max height of the editor
        minHeight: 200, // Min height of the editor
        airMode: false, // Disable airMode, the floating toolbar

        // Full toolbar configuration with more options
        toolbar: [
            // Group 1
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['style', ['style']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // Group 2
            ['insert', ['link', 'picture', 'video']],
            ['table', ['table']],
            ['hr', ['hr']],
            // Group 3
            ['view', ['fullscreen', 'codeview', 'help']],
        ],

        // Callbacks for specific events
        callbacks: {
            // Triggered when content is changed in the editor
            onChange: function(contents) {
                @this.set('description', contents);  // Set content to Livewire property 'description'
            },
            // Triggered when an image is uploaded
            onImageUpload: function(files) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let image = $('<img>').attr('src', e.target.result);
                    $('#summernote').summernote('insertNode', image[0]);
                };
                reader.readAsDataURL(files[0]);
            },
            // Triggered when a link is inserted
            onLinkInsert: function(url) {
                console.log('Link inserted:', url);
            },
        },

        // Optional: Additional settings for responsiveness, placeholder, etc.
        focus: true, // Automatically focus the editor when it loads
        disableDragAndDrop: true, // Disable drag-and-drop of files (images, etc.)
    });
</script>





</div>


