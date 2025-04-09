<?php

namespace App\Livewire\Guest;

use App\Mail\Kontaktanfrage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Kontakt extends Component
{
    public string $nachname = '';

    public string $email = '';

    public string $telefon = '';

    public string $adresse = '';

    public string $anliegen = '';

    public function rules()
    {
        return [
            'nachname' => 'required|min:2',
            'email' => 'required|email',
            'telefon' => 'required|min:2',
            'adresse' => 'nullable',
            'anliegen' => 'required|min:2',
        ];
    }

    public function send()
    {
        $this->validate();
        toast()->success('Ihr Anliegen wurde gesendet', 'Achtung')->push();
        Mail::to('info@e-neko.de')
            ->send(new Kontaktanfrage($this->nachname, $this->email, $this->telefon, $this->adresse, $this->anliegen));
        redirect()->route('guest.kontakt');
    }

    public function render()
    {
        return view('livewire.guest.kontakt');
    }
}
