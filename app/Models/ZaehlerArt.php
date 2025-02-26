<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZaehlerArt extends Model
{
    use HasFactory;
    protected $table = 'zaehler_arten';

    protected $appends = ['short_key'];

    protected $fillable = [
        'id', 'caption', 'einheit_id', 'sort_reihenfolge'
    ];

    protected function getShortKeyAttribute(){
        return $this->id;
    }

}
