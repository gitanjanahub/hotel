<div class="content-wrapper" style="margin-left: 5% !important;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark">About Us</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">About Us Details</h3>
                        </div>
                        <div class="container mt-4">
                            @if (session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            <form wire:submit.prevent="saveAboutUs" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" wire:model="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
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
                                            <label>Home Page Title</label>
                                            <input type="text" wire:model="home_title" class="form-control">
                                            @error('home_title') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Home Page Content</label>
                                            <textarea wire:model="home_content" class="form-control"></textarea>
                                            @error('home_content') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Video URL</label>
                                            <input type="url" class="form-control" wire:model.defer="video_url">
                                            @error('video_url') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Video Title</label>
                                            <input type="text" wire:model="video_title" class="form-control">
                                            @error('video_title') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Video Description</label>
                                            <textarea wire:model="video_description" class="form-control"></textarea>
                                            @error('video_description') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Video Thumbnail</label>
                                            <input type="file" wire:model="video_thumb" class="form-control" accept="image/*">
                                            @error('video_thumb') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if(isset($aboutUs->video_thumb))
                                                <img src="{{ asset('storage/' . $aboutUs->video_thumb) }}" width="100" height="100" class="mt-2">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Main Images</label>
                                            <input type="file" wire:model="images" class="form-control" accept="image/*" multiple>
                                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if($images)
                                                <div class="mt-2">
                                                    @foreach($images as $image)
                                                        <img src="{{ $image->temporaryUrl() }}" width="100" class="m-2">
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if(isset($aboutUs->images))
                                                @foreach(json_decode($aboutUs->images) as $image)
                                                    <img src="{{ asset('storage/' . $image) }}" width="100" class="m-2">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Home Images</label>
                                            <input type="file" wire:model="home_images" class="form-control" accept="image/*" multiple>
                                            @error('home_images.*') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if($home_images)
                                                <div class="mt-2">
                                                    @foreach($home_images as $image)
                                                        <img src="{{ $image->temporaryUrl() }}" width="100" class="m-2">
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if(isset($aboutUs->home_images))
                                                @foreach(json_decode($aboutUs->home_images) as $image)
                                                    <img src="{{ asset('storage/' . $image) }}" width="100" class="m-2">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
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
