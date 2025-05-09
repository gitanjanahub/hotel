
<div>
<!-- Login Modal -->
<div wire:ignore.self class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger font-weight-bold">Member Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-left">Sign in with your username and password.</p>

                <form wire:submit.prevent="login">
                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                        @error('email')
                        <p class="text-danger mt-1 d-flex align-items-center fs-5">
                             {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input type="password" wire:model.defer="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        @error('password')
                        <p class="text-danger mt-1 d-flex align-items-center fs-5">
                             {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <input type="hidden" wire:model="redirect_url" value="{{ url()->current() }}">

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="#" class="small"
                           style="all: unset; color: black; text-decoration: underline; cursor: pointer;"
                           onmouseover="this.style.color='red'"
                           onmouseout="this.style.color='black'">
                            Forgot Password?
                        </a>

                        <button type="submit" class="btn btn-danger px-4">Sign in</button>
                    </div>
                </form>

                <!-- Link to Register -->
                <div class="small mt-3 text-left">
                    <strong>Not a member yet?</strong>
                    <a href="#"
                       data-dismiss="modal"
                       data-toggle="modal"
                       data-target="#registerModal"
                       style="all: unset; color: black; text-decoration: underline; cursor: pointer;"
                       onmouseover="this.style.color='red'"
                       onmouseout="this.style.color='black'">
                        Create an account.
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Register Modal (PLACE THIS OUTSIDE) -->
<div wire:ignore class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                {{-- <h5 class="modal-title text-primary font-weight-bold">Create an Account</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body overflow-auto" style="max-height: 80vh;">

                <livewire:auth.register-page/>
            </div>

        </div>
    </div>
</div>

</div>

{{-- @push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // When the modal is about to hide, remove focus from any input inside it
        $('#registerModal, #loginModal').on('hide.bs.modal', function () {
            if (document.activeElement) {
                document.activeElement.blur();
            }
        });

        // Optional: Dispatch a Livewire event after the modal is fully hidden
        $('#registerModal, #loginModal').on('hidden.bs.modal', function () {
            if (window.Livewire) {
                window.Livewire.dispatch('modalClosed');
            }
        });
    });
</script>
@endpush --}}


<script>
    document.addEventListener('livewire:initialized', () => {
    $('#registerModal, #loginModal').on('hidden.bs.modal', function () {
        //console.log('Modal hidden, dispatching Livewire event...');
        window.Livewire.dispatch('modalClosed');
    });
});
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#loginModal').on('show.bs.modal', function () {
            const redirectUrl = document.getElementById('redirect_url')?.value || '/';

            // Emit Livewire event with redirect URL
            Livewire.dispatch('setRedirectUrl', { redirectUrl: redirectUrl });
        });
    });
</script> --}}








