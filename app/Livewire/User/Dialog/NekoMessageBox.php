<?php

namespace App\Livewire\User\Dialog;

use App\Http\Traits\Helpers;
use Livewire\Component;

class NekoMessageBox extends Component
{
    use Helpers;

    public $showNekoMessageMutex = false;

    public $title = 'Title';

    public $message = 'Message?';

    public $boxType = 'info';

    public $submitText = 'OK';

    public $cancelText = 'Abbrechen';

    protected $listeners = [
        'showNekoMessageModal' => 'showNekoMessage',
    ];

    public function showNekoMessage($params = null)
    {
        $this->params = $params;
        $this->title = $this->getParam('title', $this->title);
        $this->message = $this->getParam('message', $this->message);
        $this->boxType = $this->getParam('type', $this->boxType);
        $this->showNekoMessageMutex = true;
    }

    public function confirm()
    {
        $this->dispatch('confirmNekoMessage', $this->params);
        $this->showNekoMessageMutex = false;
    }

    public function render()
    {
        return view('livewire.user.dialog.neko-message-box');
    }
}
