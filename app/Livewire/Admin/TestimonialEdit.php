<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.adminpanel')]
#[Title('Testimonial Create')]

class TestimonialEdit extends Component
{

    use WithFileUploads;

    public $testimonial;
    public $name;
    public $image;
    public $newImage;
    public $content;

    public function mount($id)
    {
        $this->testimonial = Testimonial::findOrFail($id);
        $this->name = $this->testimonial->name;
        $this->image = $this->testimonial->image; // Store the existing image path
        $this->content = $this->testimonial->content;
    }

    public function save()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required|min:3|max:255',
            'content' => 'required|string',
            'newImage' => 'nullable|image|max:2048', // New image is optional
        ]);

        // Check if a new image is uploaded
        if ($this->newImage) {
            // Delete the old image if it exists
            if ($this->image && Storage::disk('public')->exists($this->image)) {
                Storage::disk('public')->delete($this->image);
            }

            // Upload new image
            $this->image = $this->newImage->store('images/testimonials', 'public');
        }

        // Update the testimonial record
        $this->testimonial->update([
            'name' => $this->name,
            'content' => $this->content,
            'image' => $this->image, // Update only if changed
        ]);

        // Reset form fields
        $this->reset(['newImage']);

        // Flash success message and redirect
        session()->flash('message', 'Testimonial updated successfully!');
        return redirect()->route('admin.testimonials');
    }

    public function render()
    {
        return view('livewire.admin.testimonial-edit');
    }
}
