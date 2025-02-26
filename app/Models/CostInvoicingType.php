<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costinvoicingtype extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id'
    ];

    public function costtypes()
    {
        return $this->hasMany(Costtype::class);
    }
}

