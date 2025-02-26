<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public $displaycolumn = 'email';
    Public $search='martin';

    public function valueSelected(User $user)
    {
        $this->emitUp('userautocomplete_userSelected', $user);
    }

    public function query() {
        return User::where('email', 'like', '%'.$this->search.'%')->orderBy('email');
    }

}
