<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Kontaktanfrage extends Mailable
{
    use Queueable, SerializesModels;

    private string $nachname = '';

    private string $email = '';

    private string $telefon = '';

    private string $adresse = '';

    private string $anliegen = '';

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(string $nachname, string $email, string $telefon, string $adresse, string $anliegen)
    {
        $this->nachname = $nachname;
        $this->email = $email;
        $this->telefon = $telefon;
        $this->adresse = $adresse;
        $this->anliegen = $anliegen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nekoerror@e-neko.de', 'Kontaktanfrage von e-neko.de')
            ->view('emails.kontaktanfrage')
            ->with([
                'nachname' => $this->nachname,
                'email' => $this->email,
                'telefon' => $this->telefon,
                'adresse' => $this->adresse,
                'anliegen' => $this->anliegen,
            ]);
    }
}
