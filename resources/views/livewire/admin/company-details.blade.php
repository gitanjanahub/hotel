<div class="content-wrapper" style="margin-left: 5% !important;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark">Company Details</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a wire:navigate href="{{ route('admin.bookings') }}" class="btn btn-primary rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 font-weight-bold">Update Company Details</h4>
                        </div>

                        <div class="card-body">
                            @if (session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <form wire:submit.prevent="saveCompanyDetails">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company Name <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="company_name" class="form-control" placeholder="Enter company name">
                                            @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <textarea wire:model="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <textarea wire:model="address" class="form-control" rows="2" placeholder="Enter address"></textarea>
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" wire:model="phone" class="form-control" placeholder="Enter phone number">
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" wire:model="email" class="form-control" placeholder="Enter email">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Fax</label>
                                            <input type="text" wire:model="fax" class="form-control" placeholder="Enter fax">
                                        </div>

                                        <div class="form-group">
                                            <label>Logo</label>
                                            <input type="file" wire:model="logo" class="form-control" accept="image/*">
                                            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if(isset($logo))
                                                <img src="{{ asset('storage/' . $logo) }}" width="100" height="100" class="mt-2">
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold">Social Media</h5>
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <input type="text" wire:model="facebook" class="form-control" placeholder="Facebook URL">
                                            @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <input type="text" wire:model="twitter" class="form-control" placeholder="Twitter URL">
                                            @error('twitter') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Instagram</label>
                                            <input type="text" wire:model="instagram" class="form-control" placeholder="Instagram URL">
                                            @error('instagram') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>YouTube</label>
                                            <input type="text" wire:model="youtube" class="form-control" placeholder="YouTube URL">
                                            @error('youtube') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <h5 class="font-weight-bold mt-3">Location</h5>
                                        <div class="form-group">
                                            <label>Latitude</label>
                                            <input type="text" wire:model="latitude" class="form-control" placeholder="Enter latitude">
                                        </div>

                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" wire:model="longitude" class="form-control" placeholder="Enter longitude">
                                        </div>
                                        <div class="form-group">
                                            <label>Footer Logo</label>
                                            <input type="file" wire:model="footer_logo" class="form-control" accept="image/*">
                                            @error('footer_logo') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if(isset($footer_logo))
                                                <img src="{{ asset('storage/' . $footer_logo) }}" width="100" height="100" class="mt-2">
                                            @endif
                                        </div>



                                    </div>

                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success btn-lg px-4 shadow">
                                        <i class="fas fa-save"></i> Save Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
