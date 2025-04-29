<div class="booking-form">
    <h3>Booking Your Hotel</h3>

    <form wire:submit.prevent="checkAvailability">
        <div class="check-date mb-3">
            <label for="date-in">Check In:</label>
            <input type="date" wire:model="check_in" class="form-control" min="{{ now()->toDateString() }}">
            @error('check_in') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="check-date mb-3">
            <label for="date-out">Check Out:</label>
            <input type="date" wire:model="check_out" class="form-control" min="{{ $check_in }}">
            @error('check_out') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row g-3 text-center">
            <div class="col-4">
                <label>Adults:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementAdults">−</button>
                    <span>{{ $adults }}</span>
                    <button type="button" wire:click="incrementAdults">+</button>
                </div>
            </div>

            <div class="col-4">
                <label>Children:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementChildren">−</button>
                    <span>{{ $children }}</span>
                    <button type="button" wire:click="incrementChildren">+</button>
                </div>
            </div>

            <div class="col-4">
                <label>Rooms:</label>
                <div class="stepper-box">
                    <button type="button" wire:click="decrementRooms">−</button>
                    <span>{{ $roomsCount }}</span>
                    <button type="button" wire:click="incrementRooms">+</button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3 w-100">Check Availability</button>
    </form>
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
        padding: 0.5rem 0.75rem;
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
</style>
@endpush

