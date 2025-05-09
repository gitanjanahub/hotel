<div>
<div class="container booking-form">
    <h2>Book Your Stay</h2>
    <form wire:submit.prevent="booknow" class="row g-4">
        <!-- Check-in and Check-out -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="date-in">Check In:</label>
                <input type="date" wire:model="check_in" class="form-control" min="{{ now()->toDateString() }}">
                @error('check_in') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="date-out">Check Out:</label>
                <input type="date" wire:model="check_out" class="form-control" min="{{ $check_in }}">
                @error('check_out') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Guests and Rooms -->
        <div class="col-md-4">
            <div class="mb-3">
                <label>Adults:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementAdults">−</button>
                    <span>{{ $adults }}</span>
                    <button type="button" wire:click="incrementAdults">+</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label>Children:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementChildren">−</button>
                    <span>{{ $children }}</span>
                    <button type="button" wire:click="incrementChildren">+</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label>Rooms:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementRooms">−</button>
                    <span>{{ $roomsCount }}</span>
                    <button type="button" wire:click="incrementRooms">+</button>
                </div>
            </div>
        </div>

        <!-- Address Details -->
        {{-- <div class="col-md-6">
            <div class="mb-3">
                <label for="address">Address:</label>
                <input type="text" wire:model="address" class="form-control" placeholder="Enter your address">
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div> --}}

        <!-- Additional Address Details -->
        {{-- <div class="col-md-6">
            <div class="mb-3">
                <label for="country">Country:</label>
                <input type="text" wire:model="country" class="form-control" placeholder="Enter your country">
                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div> --}}

        {{-- <div class="col-md-6">
            <div class="mb-3">
                <label for="state">State/Province:</label>
                <input type="text" wire:model="state" class="form-control" placeholder="Enter your state or province">
                @error('state') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div> --}}

        {{-- <div class="col-md-6">
            <div class="mb-3">
                <label for="pincode">Pincode:</label>
                <input type="text" wire:model="pincode" class="form-control" placeholder="Enter your pincode">
                @error('pincode') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div> --}}

        <!-- Guest's Contact Details -->
        <div class="col-md-4">
            <div class="mb-3">
                <label for="email">Name:</label>
                <input type="text" wire:model="name" class="form-control" placeholder="Your name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" wire:model="email" class="form-control" placeholder="Your email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="phone">Phone:</label>
                <input type="text" wire:model="phone" class="form-control" placeholder="Your phone number">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary mt-3 w-100">Book Now</button>
        </div>
    </form>
</div>
</div>

@push('styles')
<style>
    .booking-form {
        font-family: 'Segoe UI', sans-serif;
    }

    .booking-form label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 4px;
        display: block;
    }

    .booking-form .form-control {
        padding: 0.75rem;
        font-size: 14px;
        height: 42px;
    }

    .stepper-box {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin-top: 5px;
    }

    .stepper-box button {
        width: 36px;
        height: 36px;
        font-size: 20px;
        font-weight: bold;
        border: 1px solid #FF8C00;
        background-color: #fff;
        color: #FF8C00;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .stepper-box button:hover {
        background-color: #FF8C00;
        color: #fff;
    }

    .stepper-box span {
        font-size: 15px;
        width: 30px;
        height: 20px;
        line-height: 20px;
        font-weight: 600;
        color: #333;
        display: inline-block;
        text-align: center;
    }

    .form-control {
        font-size: 14px;
        height: 42px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn {
        background-color: #FF8C00;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #e57c00;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush
