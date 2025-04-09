<?php

namespace Database\Seeders;

use App\Models\CostInvoicingType;
use Illuminate\Database\Seeder;

class CostinvoicingtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostInvoicingType::create(['id' => 'BE', 'caption' => 'Betriebskostenabrechnung']);
        CostInvoicingType::create(['id' => 'HZ', 'caption' => 'Heizkostenabrechnung']);
        CostInvoicingType::create(['id' => 'NO', 'caption' => 'geht in keine Abrechnung']);
        CostInvoicingType::create(['id' => 'WA', 'caption' => 'Wasserabrechnung (Kalt und/oder  Warm)']);
    }
}
