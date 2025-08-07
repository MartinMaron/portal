<?php

namespace App\Livewire\User\Cost;

use App\Models\Cost;
use Livewire\Component;

class BetriebskostenModal extends Component
{
    public $dialogMode = 'init';
    public $current;
    public $showEditModal = false;

    protected $listeners = [
        'editBetriebskostenModal' => 'showModal',
        'closeBetriebskostenModal' => 'closeModal',
        'createBetriebskostenModal' => 'createModal',
    ];
    
public function rules()
    {
        return [
            'current.caption' => 'required|min:2',
        ];
    }


public function showModal($cost)
    {
        $this->dialogMode = 'edit';
        $this->showEditModal = true;
    }

    public function closeModal($save)
    {
        $this->showEditModal = false;
    }

    public function createModal($cost)
    {
        $this->current = $cost;
        $this->dialogMode = 'create';
        $this->showEditModal = true;
    }



    public function render()
    {
        return view('livewire.user.cost.betriebskostenmodal');
    }
}
