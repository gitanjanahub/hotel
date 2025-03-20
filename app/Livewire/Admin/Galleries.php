<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.adminpanel')]
#[Title('Manage Gallery')]

class Galleries extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // Use Bootstrap pagination styling

    public function render()
    {
        $galleries = Gallery::latest()->paginate(5);

        return view('livewire.admin.galleries', [
            'galleries' => $galleries,
        ]);
    }
}
