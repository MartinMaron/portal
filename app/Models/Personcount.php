<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personcount extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','nekoId', 'occupant_id', 'countvalue','abrechnungssetting_id','OptimisticLockField'
    ];

    public function occupant()
    {
        return $this->belongsTo(Realestate::class);
    }
}
