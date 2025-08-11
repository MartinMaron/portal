<?php

namespace App\Http\Traits\Helper;

trait RealestateHelper
{
    /**
     * Prüft ob irgendein Occupant ein customEinheitNo Feld gesetzt hat.
     */
    protected function hasAnyCustomEinheitNo($realestate): bool
    {
        if (! $realestate) return false;
        // nutzt bereits geladene Beziehung, sonst lazy
        return (bool) $realestate->occupants->where('customEinheitNo', '<>', '')->count();
    }

    /**
     * Prüft ob irgendein Occupant ein eigentumer Feld (Eigentümer) gesetzt hat.
     */
    protected function hasAnyEigentumer($realestate): bool
    {
        if (! $realestate) return false;
        return (bool) $realestate->occupants->where('eigentumer', '<>', '')->count();
    }

    /**
     * Prüft ob irgendein Occupant vat == 1 besitzt.
     */
    protected function hasVat($realestate): bool
    {
        if (! $realestate) return false;
        return (bool) $realestate->occupants->where('vat', '=', '1')->count();
    }
}
