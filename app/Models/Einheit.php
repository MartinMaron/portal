<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Einheit extends Model
{
    use HasFactory;

//    protected $table = 'einheiten';

    protected $fillable = [
       'id', 'caption', 'shortname', 
    ];
   
}
