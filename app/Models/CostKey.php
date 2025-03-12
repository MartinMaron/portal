<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usernotnull\Toast\Concerns\WireToast;

class Costkey extends Model
{
    use HasFactory;
    use WireToast;

    protected $fillable = [
        'nekoKey_id', 'realestate_id', 'bemerkung', 'description', 'zeitanteil', 'einheit', 'shortKey', 'viewText',
    ];

    public function realestate()
    {
        return $this->belongsTo(Realestate::class);
    }

    public function einheit()
    {
        return $this->belongsTo(Einheit::class);
    }
}
