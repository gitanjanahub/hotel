<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"> <!-- modal-lg increases width -->
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger font-weight-bold">Member Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-left">Sign in with your username and password.</p>
                <form >
                <div class="form-group">
                    <input type="email" wire:model="email" class="form-control" placeholder="Email">
                    @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" wire:model="password" class="form-control" placeholder="Password">
                    @error('password')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot + Sign In button on same line -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="#"
                       class="small"
                       style="all: unset; color: black; text-decoration: underline; cursor: pointer;"
                       onmouseover="this.style.color='red'"
                       onmouseout="this.style.color='black'">
                        Forgot Password?
                    </a>

                    <button wire:click="login" type="button"  class="btn btn-danger px-4">Sign in</button>
                </div>
                </form>

                <!-- Create account line -->
                <div class="small mt-3 text-left">
                    <strong>Not a member yet?</strong>
                    <a href="#"
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
