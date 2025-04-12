<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostInvoicingType extends Model
{
    use HasFactory;

    protected $table = 'cost_invoicing_types';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
    ];

    public function costtypes()
    {
        return $this->hasMany(CostType::class);
    }
}
