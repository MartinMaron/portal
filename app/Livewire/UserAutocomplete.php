<?php

namespace App\Livewire;

use App\Models\User;

class UserAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public $displaycolumn = 'email';

    public $search = 'martin';

    public function valueSelected(User $user)
    {
        $this->emitUp('userautocomplete_userSelected', $user);
    }

    public function query()
    {
        return User::where('email', 'like', '%'.$this->search.'%')->orderBy('email');
    }
}
