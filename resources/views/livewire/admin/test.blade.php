<div> <!-- Single root wrapper added -->
    <div class="content-wrapper" style="margin-left: 5% !important;">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label for="description">Room Description</label>
                            <div wire:ignore>
                                <textarea wire:model.defer="description" id="summernote"></textarea>
                            </div>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Ensure jQuery is loaded -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap is loaded -->

    <script>
        // Initialize Summernote editor with proper callback
        $('#summernote').summernote({
            placeholder: 'Type something cool',
            tabsize: 2,
            height: 200,
            focus: true,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['paragraph']],
                ['insert', ['picture', 'video']],
            ],
            callbacks: {
                onChange: function(contents) {
                    @this.set('description', contents);  // Corrected to pass the contents instead of event
                },
            }
        });
    </script>
</div> <!-- Closing root wrapper -->
