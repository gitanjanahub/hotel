<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Livewire\Component;

class NewsletterSubscription extends Component
{
    public $email; // for the subscription form
    public $successMessage;

    public function subscribe()
{
    // Reset previous success message
    $this->reset('successMessage');

    // Validation
    $this->validate([
        'email' => 'required|email|unique:newsletters,email',
    ]);

    // Store the email in the newsletters table
    Newsletter::create([
        'email' => $this->email,
    ]);

    // Set success message and reset form field
    $this->successMessage = 'Thank you for subscribing to our newsletter!';
    $this->reset('email');
}



    public function render()
    {
        return view('livewire.newsletter-subscription');
    }
}
