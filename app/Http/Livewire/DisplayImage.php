<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DisplayImage extends Component
{

    public $message = 'Hello World!';
    public function render()
    {
        return view('livewire.display-image');
    }
}
