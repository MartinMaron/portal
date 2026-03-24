<?php

namespace App\Mail;

use App\Models\Cost;
use App\Models\Realestate;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Abrversenden extends Mailable
{
    use Queueable, SerializesModels;

    public Realestate $realestate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Realestate $realestate)
    {
        $this->realestate = $realestate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $costs = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {
                $query->IsBrennstoffkosten()
                    ->with('costAmounts');
            })->get();

        $heatingCosts = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {
                $query->IsHeizkosten()
                    ->with('costAmounts');
            })->get();

        $operatingCosts = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {
                $query->IsBetriebskosten()
                    ->with('costAmounts');
            })->get();

        return $this->from('noreply@e-neko.de', 'eneko - Portal')
            ->view('emails.abrversenden')
            ->subject($this->realestate->address . ' - Daten für Heizkosten übermittelt')
            ->with(['costs' => $costs, 'heatingCosts' => $heatingCosts, 'operatingCosts' => $operatingCosts]);
    }
}
