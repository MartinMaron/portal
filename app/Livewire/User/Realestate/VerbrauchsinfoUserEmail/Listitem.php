<?php

namespace App\Livewire\User\Realestate\VerbrauchsinfoUserEmail;

use App\Models\VerbrauchsinfoUserEmail;
use Livewire\Component;
use App\Livewire\DataTable\WithCachedRows;

class Listitem extends Component
{
    use WithCachedRows;

    public VerbrauchsinfoUserEmail $userEmail;

    public function mount(VerbrauchsinfoUserEmail $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function emit_EditModal()
    {
        $this->dispatch('showUserEmailModal', $this->userEmail);
    }

    public function emit_QuestionDeleteModal()
    {
        $this->dispatch('showQuestionDeleteModal', 'VerbrauchsinfoUserEmail', $this->userEmail['id'], 'Löschen bestätigen', 'Wollen Sie die Benachrichtigung an '.  $this->userEmail['Display'].  ' wirklich entfernen?');
    }

    public function render()
    {
        return view('livewire.user.realestate.verbrauchsinfo-user-email.listitem');
    }
}
