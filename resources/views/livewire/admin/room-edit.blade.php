<div>
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Room</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a wire:navigate href="{{ route('admin.rooms') }}" class="btn btn-primary rounded-pill">
                                <i class="fas fa-arrow-left"></i> Back to Rooms
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
                                <h3 class="card-title">Edit Room</h3>
                            </div>
                            <!-- Form Start -->
                            <form wire:submit.prevent="update" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Column 1 -->
                                        <div class="col-md-6">
                                            <!-- Room Name -->
                                            <div class="form-group">
                                                <label for="name">Room Name</label>
                                                <input type="text" id="name" class="form-control" wire:model="name">
                                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
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
                                                            <!-- Preselect services that are already associated with the room -->
                                                            <input
                                                                type="checkbox"
                                                                id="service_{{ $service->id }}"
                                                                class="form-check-input"
                                                                wire:model="selected_services"
                                                                value="{{ $service->id }}"
                                                                @checked(in_array($service->id, $selected_services))
                                                            >
                                                            <label for="service_{{ $service->id }}" class="form-check-label">
                                                                {{ $service->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('selected_services') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>


                                            <!-- Is Active -->
                                            <div class="form-group">
                                                <label for="isActive">Is Active</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" wire:model="is_active" class="custom-control-input" id="isActive"  @checked($this->is_active)>
                                                    <label class="custom-control-label" for="isActive"></label>
                                                </div>
                                            </div>

                                            <div class="form-group" wire:ignore>
                                                <label for="description">Room Description</label>
                                                <textarea id="summernote" class="form-control" wire:model.defer="description" wire:ignore>{{ $description }}</textarea>
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
                                                <input type="number" id="children" class="form-control" wire:model="children">
                                                @error('children') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>



                                            <!-- Thumbnail Image -->
                                            <div class="form-group">
                                                <label for="image">Thumbnail Image</label>
                                                <input type="file" id="image" class="form-control-file" wire:model="image">
                                                @if ($image)
                                                    <img src="{{ $image->temporaryUrl() }}" alt="Thumbnail Preview" class="mt-2 img-thumbnail" width="150">
                                                @else
                                                    <img src="{{ Storage::url($existingImages['image']) }}" alt="Existing Thumbnail" class="img-thumbnail mt-2" style="width: 150px;">
                                                @endif
                                                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="home_thumb">Home Page Thumbnail Image</label>
                                                <input type="file" id="home_thumb" class="form-control-file" wire:model="home_thumb">
                                                @if ($home_thumb)
                                                    <img src="{{ $home_thumb->temporaryUrl() }}" alt="Thumbnail Preview" class="mt-2 img-thumbnail" width="150">
                                                @else
                                                  @if ($existingImages['home_thumb'])
                                                    <img src="{{ Storage::url($existingImages['home_thumb']) }}" alt="Existing Thumbnail" class="img-thumbnail mt-2" style="width: 150px;">
                                                    @endif
                                                @endif
                                                @error('home_thumb') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>



                                            <!-- Additional Images -->
                                            <div class="form-group">
                                                <label for="images">Additional Images</label>
                                                <input type="file" id="images" class="form-control-file" wire:model="images" multiple>
                                                    <div class="mt-2">
                                                        @if ($images && count($images) > 0)
                                                            <!-- Display newly uploaded images -->
                                                            @foreach ($images as $img)
                                                                <img src="{{ $img->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail mr-2" style="width: 100px;">
                                                            @endforeach
                                                        @elseif (!empty($existingImages['images']) && is_array($existingImages['images']))
                                                            <!-- Display existing images with delete option -->
                                                            @foreach($existingImages['images'] as $key => $img)

                                                                <div class="d-inline-block position-relative mr-2">
                                                                    <!-- Image with fixed dimensions -->
                                                                    <img src="{{ Storage::url($img) }}" alt="Existing Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">

                                                                    <!-- Delete Button positioned on the top-right corner -->
                                                                    <button type="button" wire:click="deleteImage('{{ $img }}', {{ $key }})" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px; padding: 5px;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>

                                                                </div>

                                                            @endforeach
                                                        @else
                                                            <!-- If no images exist -->
                                                            <p>No images available.</p>
                                                        @endif
                                                    </div>
                                                @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit and Cancel Buttons -->
                                    <div class="form-group text-center mt-3">
                                        <button type="submit" class="btn btn-success">Update Room</button>
                                        <a wire:navigate href="{{ route('admin.rooms') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>

                                            @if ($img_message)
                    <div class="alert alert-success">
                        {{ $img_message }}
                    </div>
                @endif
            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- <script>
        document.addEventListener('livewire:load', function () {
            $('#summernote').summernote({
                height: 300, // Set height
                callbacks: {
                    onChange: function(contents) {
                        @this.set('description', contents); // Sync with Livewire property
                    }
                }
            });

            // Set initial value from Livewire when loaded
            Livewire.on('setDescription', content => {
                $('#summernote').summernote('code', content);
            });
        });
    </script> --}}

    <!-- Ensure jQuery is loaded -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap is loaded -->

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
