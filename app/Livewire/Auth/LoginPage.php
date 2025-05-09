<?php

namespace App\Livewire\Auth;

use App\Helpers\RedirectHelper;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';

    public string $redirect_url = '/';

    protected $listeners = ['modalClosed' => 'resetForm'];

    public function mount()
    {
        $this->redirect_url = url()->current();
    }


    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            //$safeUrl = $this->validateRedirectUrl($this->redirect_url);
            //return redirect($safeUrl);
            $safeUrl = RedirectHelper::validate($this->redirect_url);
            return redirect($safeUrl);
        }

        $this->addError('email', 'Invalid email or password.');
    }

    public function resetForm()
    {
        $this->reset([
            'email',
            'password',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }

    /**
     * Validates the redirect URL and returns a safe path.
     */
    // private function validateRedirectUrl($url)
    // {
    //     $parsed = parse_url($url);
    //     $path = $parsed['path'] ?? '/';

    //     if (preg_match('#^/rooms(/[\w-]+)?$#', $path)) {
    //         return $path;
    //     }

    //     return '/';
    // }
}
