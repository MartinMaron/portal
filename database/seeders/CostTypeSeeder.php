<?php

namespace Database\Seeders;

use App\Models\CostType;
use Illuminate\Database\Seeder;

class CosttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostType::create(['id' => 'BEK', 'caption' => 'Betriebskosten', 'costinvoicingtype_id' => 'BE', 'sort' => 1001]);
        CostType::create(['id' => 'BRK', 'caption' => 'Brennstoffkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 1]);
        CostType::create(['id' => 'HNK', 'caption' => 'Heiznebenkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 2]);
        CostType::create(['id' => 'ZUK', 'caption' => 'Zusatzkosten Heizung', 'costinvoicingtype_id' => 'HZ', 'sort' => 3]);
        CostType::create(['id' => 'ZKW', 'caption' => 'Zusatzkosten Warmwasser', 'costinvoicingtype_id' => 'HZ', 'sort' => 4]);
        CostType::create(['id' => 'KWK', 'caption' => 'Kaltwasserkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 5]);
        CostType::create(['id' => 'ZWA', 'caption' => 'Zwischenablesung', 'costinvoicingtype_id' => 'HZ', 'sort' => 98]);
        CostType::create(['id' => 'DIR', 'caption' => 'Direkkosten Nutzer', 'costinvoicingtype_id' => 'HZ', 'sort' => 97]);
        CostType::create(['id' => 'BEE', 'caption' => 'Betriebskosten Nutzer', 'costinvoicingtype_id' => 'BE', 'sort' => 1002]);
        CostType::create(['id' => 'KWA', 'caption' => 'Abwasser', 'costinvoicingtype_id' => 'HZ', 'sort' => 6]);
        CostType::create(['id' => 'BEH', 'caption' => 'Betriebskosten (HZ)', 'costinvoicingtype_id' => 'HZ', 'sort' => 7]);
    }
}
