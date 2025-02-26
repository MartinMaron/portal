<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prepaid extends Model
{
    use HasFactory;

    protected $fillable = [
        'nekoId', 'occupant_id', 'netAmount', 'grosAmount','prepaidtype', 'abrechnungssetting_id'
    ];

    
    public function occupant()
    {
        return $this->belongsTo(Realestate::class);
    }
}
