<?php

namespace App\Http\Livewire\User\Dialog;

use Livewire\Component;

class NekoMessageBox extends Component
{
    use \App\Http\Traits\Helpers;

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
        $this->emit('confirmNekoMessage', $this->params);
        $this->showNekoMessageMutex = false;
    }

    public function render()
    {
        return view('livewire.user.dialog.neko-message-box');
    }
}
