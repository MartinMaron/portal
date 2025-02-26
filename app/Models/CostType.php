<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costtype extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'caption', 'id', 'costinvoicingtype_id'
    ];

    public function scopeIsHeizkosten($query)
    {
        $ret_val = $query
        ->where(function($query)
        {
            $query->where('type_id', 'HNK')
            ->orWhere('type_id', 'BRK')
            ->orWhere('type_id', 'KWK')
            ->orWhere('type_id', 'KWA')
            ->orWhere('type_id', 'ZKW')
            ->orWhere('type_id', 'ZUK');
        });
        return $ret_val;
    }

    public function scopeIsBetriebskosten($query)
    {
        $ret_val = $query
        ->where(function($query)
        {
            $query->where('type_id', 'BEK')
            ->orWhere('type_id', 'BEE');
        });
        return $ret_val;
    }

    public function costinvoicingtype()
    {
        return $this->belongsTo(Costinvoicingtype::class);
    }
}
