<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleButton extends Component
  {
      public bool $hasStock;

      public function mount()
      {
          $this->hasStock = false;
      }
      public function render()
      {
          return view('livewire.toggle-button');
      }    
}
