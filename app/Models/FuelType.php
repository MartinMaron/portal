<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    use HasFactory;

    protected $table = 'fueltypes';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
        'hasTank', 'caption',
    ];

    public function einheit()
    {
        return $this->belongsTo(Einheit::class);
    }
}
