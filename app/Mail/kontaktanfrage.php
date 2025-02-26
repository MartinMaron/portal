<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class kontaktanfrage extends Mailable
{
    use Queueable, SerializesModels;

    private String $nachname = '';
    private String $email = '';
    private String $telefon = '';
    private String $adresse= ''; 
    private String $anliegen= '';

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(String $nachname, String $email, String $telefon, String $adresse, String $anliegen)
    {
        $this->nachname  = $nachname;
        $this->email  = $email;
        $this->telefon  = $telefon;
        $this->adresse  = $adresse;
        $this->anliegen  = $anliegen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nekoerror@e-neko.de', 'Example')
                    ->view('emails.kontaktanfrage')
                    ->with([
                        'nachname' => $this->nachname,
                        'email' => $this->email,
                        'telefon' => $this->telefon,
                        'adresse' => $this->adresse,
                        'anliegen' => $this->anliegen,                        
                    ]);;
    }
}
