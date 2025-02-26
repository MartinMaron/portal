<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVerbrauchsinfoAccessControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'occupant_id', 'user_id', 'neko_id', 'jahr_monat', 'datum'
    ];
    
    protected $appends = ['datum'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }

    public function getdatumAttribute()
    {
        $jm = explode('-', $this->jahr_monat);
        return new Carbon($jm[0]."-".$jm[1]."-01");
    }

    public static function validateImportData($data)
    {
        return  Validator::make($data, [
            'neko_lokator_id' => 'required|string|max:40',
            'email' => 'required|email',
            'jahr_monat' => 'required|string|max:7',
            'neko_id' => 'required|integer',
        ]);
    }
}
