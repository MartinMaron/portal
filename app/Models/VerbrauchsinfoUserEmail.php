<?php

namespace App\Models;

use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Scalar\MagicConst\Dir;
use App\Events\VerbrauchsinfoUserEmailAdded;
use App\Events\VerbrauchsinfoUserEmailDeleted;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerbrauchsinfoUserEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'realestate_id', 'nutzeinheitNo',
        'email', 'firstinitUsername', 'occupant_id',
        'infoPerPortal','infoPerEmail','infoPerPost',
    ];


    public function createdFromWebForOccupant()
    {
        return $this->belongsTo(VerbrauchsinfoUserEmail::class);
    }

    public static function validateImportData($data) {
        return Validator::make($data, [
            'msk_nr' => 'required|numeric',
            'email' => 'required|string|max:255',
        ]);
    }

    public function realestate()
    {
        return $this->belongsTo(Realestate::class);
    }

    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }
    
    protected $dispatchesEvents = [
        'created' => VerbrauchsinfoUserEmailAdded::class,
    ];
}
