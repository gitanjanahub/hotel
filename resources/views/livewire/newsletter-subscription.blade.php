<div>
    <div>
        {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
        @if ($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endif
    <form wire:submit.prevent="subscribe" class="fn-form">
        <input type="email" wire:model="email" placeholder="Email" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        <button type="submit" wire:loading.attr="disabled"><i class="fa fa-send"></i></button>
    </form>
    </div>
</div>
