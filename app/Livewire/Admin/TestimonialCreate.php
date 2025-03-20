<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.adminpanel')]
#[Title('Testimonial Create')]

class TestimonialCreate extends Component
{

    use WithFileUploads;

    public $name;
    public $image;
    public $content;



    public function save(){

        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'image' => 'required|image|max:2048',
            'content' => 'required|string',
        ]);




        // Save the roomtype to the database
        $saved = Testimonial::create([
            'name' => $this->name,
            'content' => $this->content,
        ]);

         // Only after successful validation and room creation, handle file uploads
         if ($this->image) {
            $imagePath = $this->image->store('images/testimonials', 'public');
            $saved->update(['image' => $imagePath]);
        }

        if($saved){

            // Reset form fields after successful submission
            $this->reset(['name', 'image','content']);

            // Send success message and redirect
            session()->flash('message', 'Testimnial created successfully!');
            return redirect()->route('admin.testimonials'); // Ensure this route exists

        }else{

            // If the save failed, flash an error message
            session()->flash('error', 'There was an issue saving the testimnial. Please try again.');

        }

    }


    public function render()
    {
        return view('livewire.admin.testimonial-create');
    }
}
