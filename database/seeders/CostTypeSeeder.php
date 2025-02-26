<?php

namespace Database\Seeders;

use App\Models\Costtype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Costtype::create(['id' => 'BEK', 'caption' => 'Betriebskosten', 'costinvoicingtype_id' => 'BE', 'sort' => 1001]);
        Costtype::create(['id' => 'BRK', 'caption' => 'Brennstoffkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 1]);
        Costtype::create(['id' => 'HNK', 'caption' => 'Heiznebenkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 2]);
        Costtype::create(['id' => 'ZUK', 'caption' => 'Zusatzkosten Heizung', 'costinvoicingtype_id' => 'HZ', 'sort' => 3]);
        Costtype::create(['id' => 'ZKW', 'caption' => 'Zusatzkosten Warmwasser', 'costinvoicingtype_id' => 'HZ', 'sort' => 4]);
        Costtype::create(['id' => 'KWK', 'caption' => 'Kaltwasserkosten', 'costinvoicingtype_id' => 'HZ', 'sort' => 5]);
        Costtype::create(['id' => 'ZWA', 'caption' => 'Zwischenablesung', 'costinvoicingtype_id' => 'HZ', 'sort' => 98]);
        Costtype::create(['id' => 'DIR', 'caption' => 'Direkkosten Nutzer', 'costinvoicingtype_id' => 'HZ', 'sort' => 97]);
        Costtype::create(['id' => 'BEE', 'caption' => 'Betriebskosten Nutzer', 'costinvoicingtype_id' => 'BE', 'sort' => 1002]);
        Costtype::create(['id' => 'KWA', 'caption' => 'Abwasser', 'costinvoicingtype_id' => 'HZ', 'sort' => 6]);
        Costtype::create(['id' => 'BEH', 'caption' => 'Betriebskosten (HZ)', 'costinvoicingtype_id' => 'HZ', 'sort' => 7]);
    }
}
