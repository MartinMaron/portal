<?php

namespace App\Http\Livewire\User\Dialog;

use Livewire\Component;

class DeleteModal extends Component
{
    public $showDeleteDialog = false;
    public $dialogTitle = '';
    public $dialogMessage = '';
    public $objectId;
    public $objectType = '';

    protected $listeners = [
        'showQuestionDeleteModal' => 'showQuestionDeleteModal', 
    ];
    
    public function showQuestionDeleteModal
    (
        $objectId,
        $objectType,
        $dialogTitle = 'Löschen bestätigen',
        $dialogMessage = 'Wollen Sie den Datensatz wirklich löschen?'
    )
    {
        $this->objectType = $objectType;
        $this->showDeleteDialog = true;
        $this->dialogTitle = $dialogTitle;
        $this->dialogMessage = $dialogMessage;
        $this->objectId = $objectId;
    }


    public function delete()
    {
        $this->emit('deleteConfirmed', $this->objectType, $this->objectId);
        $this->showDeleteDialog = false;
    }

    
    public function render()
    {
        return view('livewire.user.dialog.delete-modal');
    }

}
