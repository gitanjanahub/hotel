<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.testmaster')]
#[Title('Room Create')]
class Test extends Component
{




    public $description , $shortDesc, $blendDesc;  // Property to bind to Summernote editor

    // public $form = [
    //     'description' => ''
    // ];

    // Save the description
    public function save()
    {

        dd($this->description);
        $validatedData = $this->validate([
            'description' => 'required',
        ]);

        // Your saving logic here (e.g., saving to the database)
        // Example: Room::create($validatedData);
    }

    public function render()
    {
        return view('livewire.admin.test');
    }
}
