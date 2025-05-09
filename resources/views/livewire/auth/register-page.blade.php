<div>
    <h4 class="text-danger font-weight-bold text-left">Sign up to receive Member Rates</h4>
    <p class="text-left">Create an account to get access to exclusive rates.</p>



    <form wire:submit.prevent="register">
        <!-- Profile Information -->
        <h5 class="text-danger mt-4 text-left">Profile Information</h5>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" wire:model.defer="first_name" class="form-control" placeholder="First Name *">
                @error('first_name')
                <p class="text-danger mt-1 d-flex align-items-center fs-5">
                    {{ $message }}
               </p>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <input type="text" wire:model.defer="last_name" class="form-control" placeholder="Last Name *">
                @error('last_name')
                <p class="text-danger mt-1 d-flex align-items-center fs-5">
                    {{ $message }}
               </p>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="email" wire:model.defer="email" class="form-control" placeholder="Email Address *">
                @error('email')
                <p class="text-danger mt-1 d-flex align-items-center fs-5">
                    {{ $message }}
               </p>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <input type="email" wire:model.defer="email_confirmation" class="form-control" placeholder="Confirm Email Address *">
                @error('email_confirmation')
                <p class="text-danger mt-1 d-flex align-items-center fs-5">
                    {{ $message }}
               </p>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <h5 class="text-danger mt-4 text-left">Password</h5>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="password" wire:model.defer="password" class="form-control" placeholder="Create Password *">
                @error('password')
                <p class="text-danger mt-1 d-flex align-items-center fs-5">
                    {{ $message }}
               </p>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <input type="password" wire:model.defer="password_confirmation" class="form-control" placeholder="Confirm Password *">
            </div>
        </div>
        <p class="small text-muted text-left text-left">
            At least 8 characters long, case sensitive, can contain !$#%, no spaces, not the same as previous password or login
        </p>

        <!-- Acknowledgement -->
        <h5 class="text-danger mt-4 text-left">Acknowledgement</h5>
        <div class="form-check text-left">
            <input class="form-check-input" type="checkbox" wire:model.defer="agree_terms" id="agreeTerms">
            <label class="form-check-label " for="agreeTerms">
                * I agree with the Privacy Terms.
            </label>
            @error('agree_terms')
            <p class="text-danger mt-1 d-flex align-items-center fs-5">
                {{ $message }}
           </p>
            @enderror
        </div>

        <div class="form-check mt-2 text-left">
            <input class="form-check-input " type="checkbox" wire:model.defer="create_account" id="createAccount">
            <label class="form-check-label " for="createAccount">
                * I would like to create an account.
            </label>
            @error('create_account')
            <p class="text-danger mt-1 d-flex align-items-center fs-5">
                {{ $message }}
           </p>
            @enderror
        </div>

        <input type="hidden" wire:model="redirect_url" value="{{ url()->current() }}">

        <!-- Buttons -->
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-outline-danger mr-2" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Create</button>
        </div>
    </form>

    <div class="text-left">
        Already a member?<a  onclick="switchToLoginModal()" style="all: unset; color: black; text-decoration: underline; cursor: pointer;"
        onmouseover="this.style.color='red'"
        onmouseout="this.style.color='black'">Sign in here.</a>
    </div>


</div>

<script>
    function switchToLoginModal() {
        $('#registerModal').modal('hide');

        // Wait until the register modal is fully hidden before showing login
        $('#registerModal').on('hidden.bs.modal', function () {
            $('#loginModal').modal('show');
            // Unbind after first use to avoid stacking events
            $(this).off('hidden.bs.modal');
        });
    }
</script>
