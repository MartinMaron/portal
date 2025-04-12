<?php

namespace Database\Seeders;

use App\Models\UnitUsageType;
use Illuminate\Database\Seeder;

class UnitUsageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitUsageType::create(['type_id' => 'APP', 'caption' => 'Appartament']);
        UnitUsageType::create(['type_id' => 'ARM', 'caption' => 'Allgemeine Räume']);
        UnitUsageType::create(['type_id' => 'AT ', 'caption' => 'Atelier']);
        UnitUsageType::create(['type_id' => 'BRO', 'caption' => 'Büro']);
        UnitUsageType::create(['type_id' => 'EIL', 'caption' => 'Einzelhandel + Lager']);
        UnitUsageType::create(['type_id' => 'EIZ', 'caption' => 'Einzelhandel']);
        UnitUsageType::create(['type_id' => 'ETG', 'caption' => 'Etage']);
        UnitUsageType::create(['type_id' => 'GAR', 'caption' => 'Garage']);
        UnitUsageType::create(['type_id' => 'GAS', 'caption' => 'Gaststätte']);
        UnitUsageType::create(['type_id' => 'GEW', 'caption' => 'Gewerbe']);
        UnitUsageType::create(['type_id' => 'HAL', 'caption' => 'Halle']);
        UnitUsageType::create(['type_id' => 'HUB', 'caption' => 'Halle u. Büro']);
        UnitUsageType::create(['type_id' => 'KEL', 'caption' => 'Keller']);
        UnitUsageType::create(['type_id' => 'LAD', 'caption' => 'Laden']);
        UnitUsageType::create(['type_id' => 'LAG', 'caption' => 'Lager']);
        UnitUsageType::create(['type_id' => 'LGE', 'caption' => 'Logische Einheit']);
        UnitUsageType::create(['type_id' => 'PRA', 'caption' => 'Praxis']);
        UnitUsageType::create(['type_id' => 'PT ', 'caption' => 'Physiotherapie']);
        UnitUsageType::create(['type_id' => 'STL', 'caption' => 'Stellplatz']);
        UnitUsageType::create(['type_id' => 'TNH', 'caption' => 'Tennishalle']);
        UnitUsageType::create(['type_id' => 'WHG', 'caption' => 'Wohnung']);
        UnitUsageType::create(['type_id' => 'ZIM', 'caption' => 'Zimmer']);

    }
}
