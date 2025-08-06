<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ToastNotification extends Component
{
    public $message = '';
    public $type = 'success';
    public $show = false;

    #[On('show-toast-notification')]
    public function showToast($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;
    }

    public function render()
    {
        return view('livewire.toast-notification');
    }
}
