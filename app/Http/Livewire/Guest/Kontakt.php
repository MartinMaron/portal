<?php

namespace App\Http\Livewire\Guest;

use App\Mail\kontaktanfrage;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Usernotnull\Toast\Concerns\WireToast;


class Kontakt extends Component
{
    public String $nachname = '';
    public String $email = '';
    public String $telefon = '';
    public String $adresse = '';
    public String $anliegen = '';

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

    public function send(){
        $this->validate();
        toast()->success('Ihr Anliegen wurde gesendet','Achtung')->push();
        Mail::to('info@e-neko.de')
        ->send(new kontaktanfrage($this->nachname, $this->email, $this->telefon, $this->adresse, $this->anliegen));
        redirect()->route('guest.kontakt');       
    }
   
    public function render()
    {
        return view('livewire.guest.kontakt');
    }
}
